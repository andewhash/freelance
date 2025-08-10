<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPremiumFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_premium_subscription')->default(false);
            $table->date('premium_subscription_until')->nullable();
            $table->decimal('order_search', 10, 2)->default(0);
            $table->decimal('order_catalog', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'has_premium_subscription',
                'premium_subscription_until',
                'order_search',
                'order_catalog'
            ]);
        });
    }
}
