<?php

namespace App\Models;

use App\Models\ArtisanProfile;
use Illuminate\Database\Eloquent\Model;

class ArtisanVerification extends Model
{
    //

    protected $fillable = [
        'artisan_id',
        'national_id_document_id',
        'verification_method',
        'status',
        'remarks',
        'verified_by',
        'verified_at'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
