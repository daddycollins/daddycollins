<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('reviews', function (Blueprint $table) {
      $table->boolean('is_featured')->default(false)->after('has_response');
      $table->boolean('is_hidden')->default(false)->after('is_featured');
      $table->string('hidden_reason')->nullable()->after('is_hidden');
    });
  }

  public function down(): void
  {
    Schema::table('reviews', function (Blueprint $table) {
      $table->dropColumn(['is_featured', 'is_hidden', 'hidden_reason']);
    });
  }
};
