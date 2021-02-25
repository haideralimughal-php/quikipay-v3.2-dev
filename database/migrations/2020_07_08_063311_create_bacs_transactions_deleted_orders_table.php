<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bacs_transactions_deleted_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tx_id');
            $table->string('receipt');
            $table->string('currency_symbol');
            $table->double('quantity');
            $table->string('status');
            $table->string('products_data');
            $table->string('rejected_reason');
            $table->string('customer_id_image');
            $table->string('customer_email');
            $table->string('customer_name');
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
        Schema::dropIfExists('bacs_transactions_deleted_orders');
    }
}
