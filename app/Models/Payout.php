<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
  protected $fillable = [
    'artisan_id',
    'amount',
    'payment_method',
    'status',
    'notes',
    'processed_at',
    'transaction_id'
  ];

  protected $casts = [
    'processed_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];

  public function artisan()
  {
    return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
  }
}
