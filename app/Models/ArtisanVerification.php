<?php

namespace App\Models;

use App\Models\User;
use App\Models\ArtisanProfile;
use App\Models\NationalDocument;
use Illuminate\Database\Eloquent\Model;

class ArtisanVerification extends Model
{
    protected $fillable = [
        'artisan_id',
        'national_id_document_id',
        'verification_method',
        'status',
        'remarks',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }

    public function nationalDocument()
    {
        return $this->belongsTo(NationalDocument::class, 'national_id_document_id');
    }

    public function verifiedByUser()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
