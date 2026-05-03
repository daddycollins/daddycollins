<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrService
{
    protected float $autoVerifyThreshold = 70.0;

    /**
     * Extract raw text from an image using Tesseract OCR.
     */
    public function extractText(string $imagePath): string
    {
        // Normalize path to fix mixed slashes on Windows
        $normalizedPath = realpath($imagePath) ?: $imagePath;

        $ocr = new TesseractOCR($normalizedPath);
        // Set the explicit path to tesseract executable on Windows
        $ocr->executable('C:\\Program Files\\Tesseract-OCR\\tesseract.exe');
        $ocr->lang('eng');
        $ocr->psm(6);   // Assume a single uniform block of text (better for ID documents)
        $ocr->dpi(300); // Force 300 DPI since images often lack metadata (Tesseract guesses 184)

        // Debug: log the command and output
        $command = $ocr->executable('C:\\Program Files\\Tesseract-OCR\\tesseract.exe')->getFullCommand();
        $output = '';
        $error = '';
        try {
            $output = $ocr->run();
            if (empty(trim($output))) {
                throw new \Exception("Tesseract returned no output.\nCommand: $command");
            }
            return $output;
        } catch (\Exception $e) {
            // Optionally log to storage/logs/laravel.log
            Log::error('Tesseract OCR error', [
                'command' => $command,
                'image' => $normalizedPath,
                'output' => $output,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception("OCR processing failed: " . $e->getMessage() . "\nCommand: $command");
        }
    }

    /**
     * Parse Zimbabwe national ID text to extract structured data.
     * Zimbabwe IDs typically contain: Full Name, ID Number (XX-XXXXXXX XX X),
     * Date of Birth, Issue Date, Expiry Date.
     */
    public function parseNationalId(string $rawText): array
    {
        $extracted = [
            'full_name' => null,
            'id_number' => null,
            'date_of_birth' => null,
            'issue_date' => null,
            'expiry_date' => null,
        ];

        $lines = array_map('trim', explode("\n", $rawText));
        $text = implode(' ', $lines);

        $surname = null;
        $firstName = null;

        foreach ($lines as $line) {
            if (preg_match('/\bID\s*NUMBER[:\s]+(.+)/i', $line, $match)) {
                $extracted['id_number'] = preg_replace('/[\s\-]+/', ' ', trim($match[1]));
                continue;
            }

            if (preg_match('/\bSURNAME[:\s]+(.+)/i', $line, $match)) {
                $surname = trim($match[1]);
                continue;
            }

            if (preg_match('/\bFIRST\s+NAME[:\s]+(.+)/i', $line, $match)) {
                $firstName = trim($match[1]);
                continue;
            }

            if (preg_match('/\bDATE\s+OF\s+BIRTH[:\s]+(.+)/i', $line, $match)) {
                $date = $this->parseDate(trim($match[1]));
                if ($date) {
                    $extracted['date_of_birth'] = $date->format('Y-m-d');
                }
                continue;
            }

            if (preg_match('/\bDATE\s+OF\s+ISSUE[:\s]+(.+)/i', $line, $match)) {
                $date = $this->parseDate(trim($match[1]));
                if ($date) {
                    $extracted['issue_date'] = $date->format('Y-m-d');
                }
                continue;
            }

            if (preg_match('/\bDATE\s+OF\s+EXPIRY|\bEXPIRY\s+DATE[:\s]+(.+)/i', $line, $match)) {
                $date = $this->parseDate(trim($match[1]));
                if ($date) {
                    $extracted['expiry_date'] = $date->format('Y-m-d');
                }
                continue;
            }
        }

        if ($surname && $firstName) {
            $extracted['full_name'] = Str::title($surname . ' ' . $firstName);
        }

        // Fallback extraction for ID number if the label-based parse failed
        if (empty($extracted['id_number']) && preg_match('/\b\d{2}[-\s]?\d{6,8}[-\s]?[A-Z]?[-\s]?\d{2}\b/i', $text, $matches)) {
            $extracted['id_number'] = preg_replace('/[\s\-]+/', ' ', trim($matches[0]));
        }

        // Fallback name parsing from any recognized name label or uppercase sequence
        if (empty($extracted['full_name'])) {
            if (preg_match('/(?:name|surname|nom)[:\s]+([A-Z][A-Za-z]+(?:\s+[A-Z][A-Za-z]+)*)/i', $text, $nameMatch)) {
                $extracted['full_name'] = trim($nameMatch[1]);
            } elseif (preg_match_all('/\b([A-Z]{2,}(?:\s+[A-Z]{2,})+)\b/', $text, $nameMatches)) {
                $longestName = '';
                foreach ($nameMatches[0] as $candidate) {
                    if (preg_match('/\d/', $candidate)) {
                        continue;
                    }
                    if (strlen($candidate) > strlen($longestName)) {
                        $longestName = $candidate;
                    }
                }
                if ($longestName) {
                    $extracted['full_name'] = Str::title($longestName);
                }
            }
        }

        return $extracted;
    }

    /**
     * Calculate confidence score by comparing OCR-extracted data with user-provided data.
     * Returns a score from 0 to 100.
     */
    public function calculateConfidence(array $extracted, array $userProvided): float
    {
        $score = 0;
        $maxScore = 0;

        // Compare ID number (weight: 50 points)
        $maxScore += 50;
        if (!empty($extracted['id_number']) && !empty($userProvided['id_number'])) {
            $ocrId = preg_replace('/[\s\-]/', '', strtoupper($extracted['id_number']));
            $userId = preg_replace('/[\s\-]/', '', strtoupper($userProvided['id_number']));
            $similarity = 0;
            similar_text($ocrId, $userId, $similarity);
            $score += ($similarity / 100) * 50;
        }

        // Compare full name (weight: 30 points)
        $maxScore += 30;
        if (!empty($extracted['full_name']) && !empty($userProvided['full_name'])) {
            $ocrName = strtolower(trim($extracted['full_name']));
            $userNameLower = strtolower(trim($userProvided['full_name']));
            $similarity = 0;
            similar_text($ocrName, $userNameLower, $similarity);
            $score += ($similarity / 100) * 30;
        }

        // Bonus for having dates extracted (weight: 20 points)
        $maxScore += 20;
        $dateFields = ['date_of_birth', 'issue_date', 'expiry_date'];
        $datesFound = 0;
        foreach ($dateFields as $field) {
            if (!empty($extracted[$field])) {
                $datesFound++;
            }
        }
        $score += ($datesFound / 3) * 20;

        return $maxScore > 0 ? round(($score / $maxScore) * 100, 2) : 0;
    }

    /**
     * Determine if the document should be auto-verified based on confidence and validity.
     */
    public function shouldAutoVerify(float $confidence, ?string $expiryDate): bool
    {
        // Use system-wide toggle and threshold
        $autoVerifyEnabled = config('custom.custom.auto_verify_artisan', false);
        $threshold = $autoVerifyEnabled ? 20.0 : $this->autoVerifyThreshold;

        if ($confidence < $threshold) {
            return false;
        }

        // If we have an expiry date, check it's not expired
        if ($expiryDate) {
            try {
                $expiry = Carbon::parse($expiryDate);
                if ($expiry->isPast()) {
                    return false;
                }
            } catch (\Exception $e) {
                // If we can't parse the expiry date, don't auto-verify
                return false;
            }
        }

        return true;
    }

    /**
     * Parse a date string in various formats to a Carbon instance.
     */
    protected function parseDate(string $dateStr): ?Carbon
    {
        $formats = [
            'd/m/Y',
            'd-m-Y',
            'd.m.Y',
            'Y-m-d',
            'Y/m/d',
            'Y.m.d',
            'd/m/y',
            'd-m-y',
            'd.m.y',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateStr);
                if ($date && $date->year > 1900 && $date->year < 2100) {
                    return $date;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }
}
