<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtisanService extends Model
{
    protected $fillable = [
        'artisan_id',
        'service_name',
        'category',
        'description',
        'price_estimate',
        'rate_type',
        'image_path',
        'availability'
    ];

    public function artisan()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }

    /**
     * Get human-readable rate type label
     */
    public function getRateTypeLabel()
    {
        $labels = [
            'per_minute' => 'Per Minute',
            'per_hour' => 'Per Hour',
            'per_day' => 'Per Day',
            'per_week' => 'Per Week',
            'per_month' => 'Per Month',
            'per_project' => 'Per Project',
            'fixed' => 'Fixed Rate'
        ];

        return $labels[$this->rate_type] ?? $this->rate_type;
    }

    /**
     * Get rate type symbol for display
     */
    public function getRateTypeSymbol()
    {
        $symbols = [
            'per_minute' => '/min',
            'per_hour' => '/hr',
            'per_day' => '/day',
            'per_week' => '/week',
            'per_month' => '/month',
            'per_project' => '(Project)',
            'fixed' => '(Fixed)'
        ];

        return $symbols[$this->rate_type] ?? '';
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'artisan_id', 'artisan_id')
            ->where('order_type', 'service');
    }
}
