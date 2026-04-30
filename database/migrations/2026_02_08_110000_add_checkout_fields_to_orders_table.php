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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('service_fee', 10, 2)->default(0)->after('total_amount');
            $table->string('paynow_poll_url')->nullable()->after('payment_method');
            $table->string('paynow_reference')->nullable()->after('paynow_poll_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['service_fee', 'paynow_poll_url', 'paynow_reference']);
        });
    }
};
