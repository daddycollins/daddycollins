<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ReviewsMonitor extends Controller
{
  public function index()
  {
    return view('content.apps.app-ecommerce-manage-reviews');
  }
}
