<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductUnit extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'abbreviation',
    'description',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }
}
