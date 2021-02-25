<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("payment_id");
            $table->double("amount");
            $table->string("currency");
            $table->string("customer_email");
            $table->string("order_id");
            $table->string("merchant");
            $table->string("site_url");
            $table->string("redirect");
            $table->string("products_data");
            $table->string("customer_name");
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
        Schema::dropIfExists('payments');
    }
}
