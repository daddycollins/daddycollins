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
        'credentials_encrypted'
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

        // If credentials are marked as encrypted, decrypt them
        if ($this->attributes['credentials_encrypted'] ?? false) {
            try {
                return decrypt($value);
            } catch (\Exception $e) {
                \Log::error('Failed to decrypt Paynow key for account ' . $this->id);
                return null;
            }
        }

        return $value;
    }

    /**
     * Set the Paynow integration key with encryption
     */
    public function setPaynowIntegrationKeyAttribute($value)
    {
        if (!$value) {
            $this->attributes['paynow_integration_key'] = null;
            return;
        }

        // Encrypt the key before storing
        $this->attributes['paynow_integration_key'] = encrypt($value);
        $this->attributes['credentials_encrypted'] = true;
    }

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }
}
