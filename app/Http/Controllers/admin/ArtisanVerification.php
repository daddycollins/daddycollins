<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ArtisanVerification extends Controller
{
  public function index()
  {
    return view('content.apps.admin-verify-artisan');
  }
}
