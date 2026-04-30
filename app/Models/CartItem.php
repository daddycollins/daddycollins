<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\ArtisanService;
use App\Models\ArtisanGood;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'item_type', 'item_id', 'quantity', 'price', 'notes'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
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
