<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
  use HasFactory;

  protected $fillable = [
    'code',
    'name',
    'symbol',
    'exchange_rate',
    'is_active',
    'is_default',
    'description',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'is_default' => 'boolean',
    'exchange_rate' => 'decimal:4',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  public function scopeDefault($query)
  {
    return $query->where('is_default', true)->first();
  }
}
