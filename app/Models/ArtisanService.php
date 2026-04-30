<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtisanService extends Model
{
    protected $fillable = [
        'artisan_id',
        'service_name',
        'category',
        'description',
        'price_estimate',
        'image_path',
        'availability'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'artisan_id', 'artisan_id')
            ->where('order_type', 'service');
    }
}
