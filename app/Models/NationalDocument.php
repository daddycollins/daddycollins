<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NationalDocument extends Model
{
    //

    protected $fillable = [
        'user_id',
        'id_number',
        'full_name',
        'front_image_path',
        'back_image_path',
        'ocr_raw_text',
        'ocr_confidence',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
