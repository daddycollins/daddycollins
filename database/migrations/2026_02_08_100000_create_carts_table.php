<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artisan_id')->constrained('artisan_profiles')->cascadeOnDelete();
            $table->timestamps();

            // One active cart per client per artisan
            $table->unique(['client_id', 'artisan_id']);
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['service', 'product']);
            $table->unsignedBigInteger('item_id'); // References either artisan_services.id or artisan_goods.id
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // Snapshot price at time of adding
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate items in same cart
            $table->unique(['cart_id', 'item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
