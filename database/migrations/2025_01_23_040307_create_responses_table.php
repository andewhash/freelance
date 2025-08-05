<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->float('price')->default(0);
            $table->string('price_format')->nullable()->default(null);
            $table->unsignedBigInteger('count')->default(0);
            $table->string('country')->nullable()->default(null);
            $table->string('category')->nullable()->default(null);
            $table->boolean('is_exists')->default(0);
            $table->unsignedBigInteger('request_id')->nullable()->default(null);
            $table->unsignedBigInteger('user_id');
            $table->string('image_path')->nullable()->default(null);
            $table->text('text')->nullable();
            $table->unsignedBigInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
