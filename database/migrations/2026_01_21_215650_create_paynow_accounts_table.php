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
        Schema::create('paynow_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artisan_id')->unique()->constrained('artisan_profiles')->cascadeOnDelete();
            $table->string('paynow_integration_id');
            $table->string('paynow_integration_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paynow_accounts');
    }
};
