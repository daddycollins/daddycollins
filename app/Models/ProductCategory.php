<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
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

  public static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (!$model->slug) {
        $model->slug = \Illuminate\Support\Str::slug($model->name);
      }
    });

    static::updating(function ($model) {
      if ($model->isDirty('name') && !$model->isDirty('slug')) {
        $model->slug = \Illuminate\Support\Str::slug($model->name);
      }
    });
  }
}
