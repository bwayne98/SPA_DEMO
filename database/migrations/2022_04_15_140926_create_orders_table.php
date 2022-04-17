<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string("id")->primary();

            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->boolean("paid")->default(false);
            $table->boolean("check_in")->default(false);
            
            $table->foreignId("lesson_id")->constrained("lessons");

            $table->string("MerchantTradeNo")->nullable();
            $table->string("TradeNo")->nullable();

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
