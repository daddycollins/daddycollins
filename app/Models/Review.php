<?php

namespace App\Models;

use App\Models\ArtisanProfile;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'artisan_id',
        'client_id',
        'rating',
        'comment',
        'response_comment',
        'response_date',
        'has_response'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
