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
    Schema::table('artisan_services', function (Blueprint $table) {
      $table->string('category')->nullable()->after('service_name');
      $table->string('image_path')->nullable()->after('description');
      $table->enum('availability', ['available', 'unavailable'])->default('available')->after('image_path');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('artisan_services', function (Blueprint $table) {
      $table->dropColumn(['category', 'image_path', 'availability']);
    });
  }
};
