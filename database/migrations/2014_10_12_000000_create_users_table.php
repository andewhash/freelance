<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('contact_email')->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('business_type')->nullable();
            $table->string('country')->nullable();
            $table->float('rating')->default(0);
            $table->boolean('exported')->default(0);
            $table->string('count_employers')->default('0');
            $table->string('year')->default(0);
            $table->string('status')->default('member');
            $table->string('password');
            $table->text('description')->default(null)->nullable();
            $table->string('address')->nullable()->default(null);
            $table->string('telegram')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('site')->nullable()->default(null);
            $table->string('whatsapp')->nullable()->default(null);
            $table->string('mark')->nullable()->default(null);
            $table->string('role');
            $table->string('image_url')->default('/avatars/default.png');
            $table->float('balance')->default(0);
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
