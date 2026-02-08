<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Set default value for existing NULL records
    DB::statement("UPDATE artisan_services SET price_estimate = 0 WHERE price_estimate IS NULL");

    Schema::table('artisan_services', function (Blueprint $table) {
      $table->decimal('price_estimate', 10, 2)->nullable(false)->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('artisan_services', function (Blueprint $table) {
      $table->decimal('price_estimate', 10, 2)->nullable()->change();
    });
  }
};
