<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('bids', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('requirement_id');
      $table->unsignedBigInteger('artisan_id');
      $table->decimal('amount', 12, 2);
      $table->text('proposal')->nullable();
      $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
      $table->timestamps();

      $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
      $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('bids');
  }
};
