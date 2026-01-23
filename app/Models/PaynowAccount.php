<?php

namespace App\Models;

use App\Models\ArtisanProfile;
use Illuminate\Database\Eloquent\Model;

class PaynowAccount extends Model
{
    //

    protected $fillable = [
        'artisan_id',
        'paynow_integration_id',
        'paynow_integration_key'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
