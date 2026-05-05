<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('currencies', function (Blueprint $table) {
      $table->id();
      $table->string('code', 3)->unique();
      $table->string('name')->unique();
      $table->string('symbol')->unique();
      $table->decimal('exchange_rate', 12, 4)->default(1);
      $table->boolean('is_active')->default(true);
      $table->boolean('is_default')->default(false);
      $table->text('description')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('currencies');
  }
};
