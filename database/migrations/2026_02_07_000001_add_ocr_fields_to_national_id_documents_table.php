<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('national_id_documents', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('full_name');
            $table->date('issue_date')->nullable()->after('date_of_birth');
            $table->date('expiry_date')->nullable()->after('issue_date');
            $table->json('ocr_extracted_data')->nullable()->after('ocr_confidence');
        });
    }

    public function down(): void
    {
        Schema::table('national_id_documents', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'issue_date', 'expiry_date', 'ocr_extracted_data']);
        });
    }
};
