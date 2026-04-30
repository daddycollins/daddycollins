<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('requirements', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id'); // client
      $table->string('title');
      $table->text('description');
      $table->string('category')->nullable();
      $table->timestamp('deadline')->nullable();
      $table->decimal('budget', 12, 2)->nullable();
      $table->enum('status', ['open', 'awarded', 'closed'])->default('open');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('requirements');
  }
};
