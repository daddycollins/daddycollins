<?php

namespace App\Services;

use Carbon\Carbon;
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
        $ocr = new TesseractOCR($imagePath);
        $ocr->lang('eng');

        return $ocr->run();
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

        // Extract Zimbabwe National ID number (format: XX-XXXXXXX XX X or XX-XXXXXXXX X XX)
        if (preg_match('/(\d{2}-\d{6,8}\s*[A-Z]\s*\d{2})/', $text, $matches)) {
            $extracted['id_number'] = preg_replace('/\s+/', ' ', trim($matches[1]));
        }

        // Extract dates (common formats: DD/MM/YYYY, DD-MM-YYYY, DD.MM.YYYY, YYYY-MM-DD)
        $datePattern = '/(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4}|\d{4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2})/';
        preg_match_all($datePattern, $text, $dateMatches);

        $dates = [];
        foreach ($dateMatches[0] as $dateStr) {
            $parsed = $this->parseDate($dateStr);
            if ($parsed) {
                $dates[] = $parsed;
            }
        }

        // Sort dates: earliest is likely DOB, middle is issue, latest is expiry
        usort($dates, function ($a, $b) {
            return $a->timestamp - $b->timestamp;
        });

        if (count($dates) >= 1) {
            $extracted['date_of_birth'] = $dates[0]->format('Y-m-d');
        }
        if (count($dates) >= 2) {
            $extracted['issue_date'] = $dates[1]->format('Y-m-d');
        }
        if (count($dates) >= 3) {
            $extracted['expiry_date'] = $dates[2]->format('Y-m-d');
        }

        // Extract name - look for text near "Name", "Surname", or multi-word uppercase sequences
        if (preg_match('/(?:name|surname|nom)[:\s]+([A-Z][A-Za-z]+(?:\s+[A-Z][A-Za-z]+)*)/i', $text, $nameMatch)) {
            $extracted['full_name'] = trim($nameMatch[1]);
        } elseif (preg_match_all('/\b([A-Z]{2,}(?:\s+[A-Z]{2,})+)\b/', $text, $nameMatches)) {
            // Pick the longest uppercase sequence as likely the full name
            $longestName = '';
            foreach ($nameMatches[0] as $candidate) {
                // Skip if it looks like an ID number or header text
                if (preg_match('/\d/', $candidate)) continue;
                if (strlen($candidate) > strlen($longestName)) {
                    $longestName = $candidate;
                }
            }
            if ($longestName) {
                $extracted['full_name'] = Str::title($longestName);
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
        if ($confidence < $this->autoVerifyThreshold) {
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
            'd/m/Y', 'd-m-Y', 'd.m.Y',
            'Y-m-d', 'Y/m/d', 'Y.m.d',
            'd/m/y', 'd-m-y', 'd.m.y',
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
