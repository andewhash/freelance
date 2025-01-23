<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Order\OrderStatusEnum;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users'); // nullable as customer can be null
            $table->foreignId('seller_id')->nullable()->constrained('users'); // assuming sellers are users
            $table->decimal('price', 10, 2);
            $table->decimal('commission_price', 10, 2);
            $table->string('title');
            $table->text('description');
            $table->integer('count_days');
            $table->enum('status', OrderStatusEnum::getAll())->default(OrderStatusEnum::NEW);
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
        Schema::dropIfExists('orders');
    }
}
