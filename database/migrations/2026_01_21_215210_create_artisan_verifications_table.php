<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artisan_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artisan_id')->unique()->constrained('artisan_profiles')->cascadeOnDelete();
            $table->foreignId('national_id_document_id')->constrained()->cascadeOnDelete();
            $table->enum('verification_method', ['manual', 'ocr-assisted']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('verified_by')->nullable()->references('id')->on('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_verifications');
    }
};
