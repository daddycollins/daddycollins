<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\NationalDocument;
use App\Models\ArtisanVerification;
use App\Http\Controllers\Controller;
class ArtsnVerification extends Controller
{
  public function index()
  {
    // Get all pending verifications with related user and artisan data
    $pendingVerifications = ArtisanVerification::where('status', 'pending')
      ->with([
        'user',
        'user.artisanProfile',
        'user.paynowAccount',
        'nationalDocument'
      ])
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
}
