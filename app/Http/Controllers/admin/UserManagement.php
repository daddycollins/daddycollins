<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class UserManagement extends Controller
{
  public function index()
  {
    return view('content.apps.user-management');
  }
}
