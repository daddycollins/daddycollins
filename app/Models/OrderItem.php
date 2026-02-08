<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ArtisanService;
use App\Models\ArtisanGood;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //

    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function artisanService()
    {
        return $this->belongsTo(ArtisanService::class, 'item_id');
    }

    public function artisanGood()
    {
        return $this->belongsTo(ArtisanGood::class, 'item_id');
    }

    /**
     * Get the item name based on item type
     */
    public function getItemNameAttribute()
    {
        return $this->item_type === 'service'
            ? $this->artisanService?->service_name
            : $this->artisanGood?->product_name;
    }

    /**
     * Get the item details (service or product)
     */
    public function getItemAttribute()
    {
        return $this->item_type === 'service'
            ? $this->artisanService
            : $this->artisanGood;
    }
}
