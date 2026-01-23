<?php

namespace App\Models;

use App\Models\ArtisanProfile;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'artisan_id',
        'client_id',
        'rating',
        'comment'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
