<?php

namespace App\Models;

use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'client_id',
        'artisan_id',
        'order_type',
        'total_amount',
        'status',
        'payment_status',
        'amount',
        'shipping_address',
        'billing_address',
        'payment_method'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
