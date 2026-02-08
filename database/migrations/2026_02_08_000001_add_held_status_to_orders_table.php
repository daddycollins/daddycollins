<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  public function up(): void
  {
    DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'completed', 'processing', 'cancelled', 'held') DEFAULT 'pending'");
  }

  public function down(): void
  {
    DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'completed', 'processing', 'cancelled') DEFAULT 'pending'");
  }
};
