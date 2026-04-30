<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
  // List all requirements (for clients and artisans)
  public function index()
  {
    $requirements = Requirement::with('user')->latest()->paginate(20);
    return view('requirements.index', compact('requirements'));
  }

  // Show form to create a new requirement (client)
  public function create()
  {
    return view('requirements.create');
  }

  // Store a new requirement
  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'category' => 'nullable|string|max:255',
      'deadline' => 'nullable|date',
      'budget' => 'nullable|numeric',
    ]);
    $data['user_id'] = auth()->id();
    Requirement::create($data);
    return redirect()->route('requirements.index')->with('success', 'Requirement posted successfully.');
  }

  // Show a single requirement and its bids
  public function show(Requirement $requirement)
  {
    // Eager load artisanProfile, orders, and reviews for each bid's artisan
    $requirement->load(['user', 'bids.artisan.artisanProfile', 'bids.artisan.orders', 'bids.artisan.reviews']);
    return view('requirements.show', compact('requirement'));
  }
}
