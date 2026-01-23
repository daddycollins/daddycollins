<?php

namespace App\Models;

use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
       protected $fillable = [
        'client_id', 'artisan_id',
        'order_type', 'total_amount', 'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
