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
    Schema::table('artisan_services', function (Blueprint $table) {
      if (!Schema::hasColumn('artisan_services', 'rate_type')) {
        $table->enum('rate_type', [
          'per_minute',
          'per_hour',
          'per_day',
          'per_week',
          'per_month',
          'per_project',
          'fixed'
        ])->default('per_hour')->after('price_estimate');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('artisan_services', function (Blueprint $table) {
      if (Schema::hasColumn('artisan_services', 'rate_type')) {
        $table->dropColumn('rate_type');
      }
    });
  }
};
