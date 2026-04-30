<?php

namespace App\Http\Controllers\artisan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bid;
use App\Models\Requirement;

class BiddingController extends Controller
{
  // Show all bids by the artisan
  public function myBids()
  {
    $bids = Bid::where('artisan_id', Auth::id())->with('requirement.user')->latest()->get();
    return view('content.apps.artisan-my-bids', compact('bids'));
  }

  // Show all open requirements for bidding
  public function openRequirements()
  {
    $requirements = Requirement::where('status', 'open')->with('user', 'bids')->latest()->get();
    return view('content.apps.artisan-open-requirements', compact('requirements'));
  }
}
