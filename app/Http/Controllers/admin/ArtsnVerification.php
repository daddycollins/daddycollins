<?php

namespace App\Http\Controllers\admin;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use App\Models\ArtisanVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArtsnVerification extends Controller
{
    public function index()
    {
        // Get all pending verifications with related data
        $pendingVerifications = ArtisanVerification::where('status', 'pending')
            ->with(['artisan.user', 'nationalDocument'])
            ->latest('created_at')
            ->get();

        // Get the first pending verification for display
        $selectedVerification = $pendingVerifications->first();

        return view('content.apps.admin-verify-artisan', [
            'pendingVerifications' => $pendingVerifications,
            'selectedVerification' => $selectedVerification,
            'totalPending' => $pendingVerifications->count(),
        ]);
    }

    public function show(ArtisanVerification $verification)
    {
        $verification->load(['artisan.user', 'nationalDocument']);

        return response()->json([
            'id' => $verification->id,
            'status' => $verification->status,
            'remarks' => $verification->remarks,
            'verification_method' => $verification->verification_method,
            'created_at' => $verification->created_at->format('M d, Y'),
            'artisan' => [
                'name' => $verification->artisan->user->name ?? 'N/A',
                'email' => $verification->artisan->user->email ?? 'N/A',
                'phone' => $verification->artisan->phone ?? 'N/A',
                'business_name' => $verification->artisan->business_name ?? 'N/A',
                'category' => $verification->artisan->category ?? 'N/A',
                'location' => $verification->artisan->location ?? 'N/A',
                'reg_date' => $verification->artisan->user->created_at->format('M d, Y'),
                'initial' => substr($verification->artisan->user->name ?? 'N', 0, 1),
            ],
            'document' => $verification->nationalDocument ? [
                'id_number' => $verification->nationalDocument->id_number,
                'full_name' => $verification->nationalDocument->full_name,
                'date_of_birth' => $verification->nationalDocument->date_of_birth?->format('M d, Y'),
                'issue_date' => $verification->nationalDocument->issue_date?->format('M d, Y'),
                'expiry_date' => $verification->nationalDocument->expiry_date?->format('M d, Y'),
                'ocr_confidence' => $verification->nationalDocument->ocr_confidence,
                'ocr_raw_text' => $verification->nationalDocument->ocr_raw_text,
                'front_image_url' => asset('storage/' . $verification->nationalDocument->front_image_path),
                'back_image_url' => $verification->nationalDocument->back_image_path
                    ? asset('storage/' . $verification->nationalDocument->back_image_path)
                    : null,
                'status' => $verification->nationalDocument->status,
                'is_expired' => $verification->nationalDocument->expiry_date
                    ? $verification->nationalDocument->expiry_date->isPast()
                    : null,
            ] : null,
            'paynow' => $verification->artisan->paynow ? [
                'account_number' => '••••••••' . substr($verification->artisan->paynow->account_number ?? '', -4),
            ] : null,
        ]);
    }

    public function approve(ArtisanVerification $verification, Request $request)
    {
        $admin = Auth::user();
        $remarks = $request->input('remarks', 'Approved by admin');

        // Update verification
        $verification->update([
            'status' => 'approved',
            'remarks' => $remarks,
            'verified_by' => $admin->id,
            'verified_at' => now(),
        ]);

        // Update national document status
        if ($verification->nationalDocument) {
            $verification->nationalDocument->update(['status' => 'verified']);
        }

        // Update artisan profile verified status
        $verification->artisan->update(['verified' => true]);

        // Log the action
        SystemLog::create([
            'user_id' => $admin->id,
            'action' => 'Approved artisan verification #' . $verification->id . ' for artisan: ' . ($verification->artisan->user->name ?? 'Unknown'),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Artisan has been approved successfully!');
    }

    public function reject(ArtisanVerification $verification, Request $request)
    {
        $request->validate([
            'remarks' => 'required|string|min:10|max:1000',
        ]);

        $admin = Auth::user();

        // Update verification
        $verification->update([
            'status' => 'rejected',
            'remarks' => $request->input('remarks'),
            'verified_by' => $admin->id,
            'verified_at' => now(),
        ]);

        // Update national document status
        if ($verification->nationalDocument) {
            $verification->nationalDocument->update(['status' => 'rejected']);
        }

        // Ensure artisan profile is not verified
        $verification->artisan->update(['verified' => false]);

        // Log the action
        SystemLog::create([
            'user_id' => $admin->id,
            'action' => 'Rejected artisan verification #' . $verification->id . ': ' . $request->input('remarks'),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Artisan verification has been rejected.');
    }

    public function requestChanges(ArtisanVerification $verification, Request $request)
    {
        $request->validate([
            'remarks' => 'required|string|min:10|max:1000',
        ]);

        $admin = Auth::user();

        // Keep status as pending but update remarks
        $verification->update([
            'status' => 'pending',
            'remarks' => 'Changes requested: ' . $request->input('remarks'),
        ]);

        // Log the action
        SystemLog::create([
            'user_id' => $admin->id,
            'action' => 'Requested changes for verification #' . $verification->id . ': ' . $request->input('remarks'),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Change request has been sent to the artisan.');
    }
}
