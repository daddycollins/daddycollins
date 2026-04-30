<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BidController extends Controller
{
  // Store a new bid for a requirement (artisan)
  public function store(Request $request, Requirement $requirement)
  {
    $data = $request->validate([
      'amount' => 'required|numeric|min:0',
      'proposal' => 'nullable|string',
    ]);
    $data['artisan_id'] = auth()->id();
    $data['requirement_id'] = $requirement->id;
    Bid::create($data);
    return redirect()->route('requirements.show', $requirement)->with('success', 'Bid submitted successfully.');
  }

  // (Optional) Accept a bid (client)
  public function accept(Bid $bid)
  {
    // Only the requirement owner (client) can accept a bid
    if (auth()->id() !== $bid->requirement->user_id) {
      abort(403, 'Unauthorized action.');
    }
    $bid->status = 'accepted';
    $bid->save();
    $bid->requirement->update(['status' => 'awarded']);
    // Optionally reject other bids
    Bid::where('requirement_id', $bid->requirement_id)->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
    return back()->with('success', 'Bid accepted and requirement awarded.');
  }
}
