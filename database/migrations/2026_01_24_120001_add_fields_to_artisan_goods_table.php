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
    Schema::table('artisan_goods', function (Blueprint $table) {
      $table->string('category')->nullable()->after('product_name');
      $table->string('unit')->nullable()->after('stock_quantity');
      $table->string('image_path')->nullable()->after('description');
      $table->enum('availability', ['available', 'unavailable'])->default('available')->after('image_path');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('artisan_goods', function (Blueprint $table) {
      $table->dropColumn(['category', 'unit', 'image_path', 'availability']);
    });
  }
};
