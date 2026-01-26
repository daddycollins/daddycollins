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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artisan_id')->constrained('artisan_profiles')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->default('paynow'); // paynow, bank_transfer
            $table->enum('status', ['pending', 'approved', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->datetime('processed_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();

            $table->index(['artisan_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
