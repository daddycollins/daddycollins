<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NationalDocument extends Model
{
    protected $table = 'national_id_documents';

    protected $fillable = [
        'user_id',
        'id_number',
        'full_name',
        'date_of_birth',
        'issue_date',
        'expiry_date',
        'front_image_path',
        'back_image_path',
        'ocr_raw_text',
        'ocr_confidence',
        'ocr_extracted_data',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'ocr_confidence' => 'decimal:2',
        'ocr_extracted_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
