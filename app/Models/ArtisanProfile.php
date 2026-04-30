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
        'average_rating',
        'phone',
        'years_of_experience',
        'business_hours',
        'address',
        'city',
        'province',
        'gender',
        'date_of_birth',
        'social_links',
        'first_name',
        'last_name',
        'profile_photo_path',
        'service_areas',
        'public_profile',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'social_links' => 'json',
        'business_hours' => 'json',
        'verified' => 'boolean',
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

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'artisan_id');
    }
}
