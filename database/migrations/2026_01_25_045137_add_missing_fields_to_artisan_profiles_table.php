<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            $table->integer('years_of_experience')->nullable()->default(0);
            $table->text('business_hours')->nullable(); // JSON structure
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other', 'Prefer not to say'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->json('social_links')->nullable(); // {facebook, instagram, whatsapp, website, linkedin}
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'years_of_experience',
                'business_hours',
                'address',
                'city',
                'province',
                'gender',
                'date_of_birth',
                'social_links',
                'first_name',
                'last_name',
            ]);
        });
    }
};
