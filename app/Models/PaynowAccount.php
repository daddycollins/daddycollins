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
        'paynow_integration_key',
        'credentials_encrypted',
        'account_holder',
        'account_type',
        'account_number',
        'phone_number',
        'bank_name',
        'branch',
        'swift_code',
        'iban',
        'status',
        'is_primary',
        'notes'
    ];

    protected $casts = [
        'credentials_encrypted' => 'boolean',
    ];

    /**
     * Get the decrypted Paynow integration key
     */
    public function getPaynowIntegrationKeyAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // For now, return as-is. Encryption can be added later.
        return $value;
    }

    /**
     * Set the Paynow integration key
     */
    public function setPaynowIntegrationKeyAttribute($value)
    {
        if (!$value) {
            $this->attributes['paynow_integration_key'] = null;
            return;
        }

        // For now, store as-is. Encryption can be added later.
        $this->attributes['paynow_integration_key'] = $value;
    }

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
