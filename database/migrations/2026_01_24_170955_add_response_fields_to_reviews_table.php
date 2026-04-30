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
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('response_comment')->nullable()->after('comment');
            $table->timestamp('response_date')->nullable()->after('response_comment');
            $table->boolean('has_response')->default(false)->after('response_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['response_comment', 'response_date', 'has_response']);
        });
    }
};
