<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class Reports extends Controller
{
  public function index()
  {
    return view('content.apps.admin-reports');
  }
}
