<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtisanGood extends Model
{
    protected $table = 'artisan_goods';

    protected $fillable = [
        'artisan_id',
        'product_name',
        'category',
        'description',
        'price',
        'stock_quantity',
        'unit',
        'image_path',
        'availability',
    ];
}