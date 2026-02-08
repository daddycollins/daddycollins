<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            $table->string('service_areas')->nullable()->after('bio');
            $table->string('profile_photo_path')->nullable()->after('last_name');
        });
    }

    public function down(): void
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            $table->dropColumn(['service_areas', 'profile_photo_path']);
        });
    }
};
