<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\ArtisanGood;
use App\Models\PaynowAccount;
use App\Models\ArtisanService;
use App\Models\ArtisanVerification;
use Illuminate\Database\Eloquent\Model;

class ArtisanProfile extends Model
{
    //

    protected $fillable = [
        'user_id',
        'business_name',
        'category',
        'location',
        'bio',
        'verified',
        'average_rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(ArtisanService::class, 'artisan_id');
    }

    public function goods()
    {
        return $this->hasMany(ArtisanGood::class, 'artisan_id');
    }

    public function paynow()
    {
        return $this->hasOne(PaynowAccount::class, 'artisan_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'artisan_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'artisan_id');
    }

    public function verification()
    {
        return $this->hasOne(ArtisanVerification::class, 'artisan_id');
    }
}
