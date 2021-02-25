<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('btc')->default(false);
            $table->string('btc_wallet')->nullable();
            $table->boolean('eth')->default(false);
            $table->string('eth_wallet')->nullable();
            $table->boolean('ltc')->default(false);
            $table->string('ltc_wallet')->nullable();
            $table->boolean('xrp')->default(false);
            $table->string('xrp_wallet')->nullable();
            $table->string('xrp_tag')->nullable();
            $table->string('success_url')->nullable();
            $table->string('success_url_fiat')->nullable();
            $table->string('crypto')->nullable();
            $table->string('bacs')->nullable();
            $table->string('khypo')->nullable();
            $table->string('khypo_credit')->nullable();
            $table->string('blockfort')->nullable();
            $table->string('hites')->nullable();
            $table->string('pago')->nullable();
            $table->string('email_flag')->nullable();
            $table->string('order_limit')->nullable();
            $table->boolean('arsToUsd')->default(false);
            $table->boolean('clpToUsd')->default(false);
            $table->boolean('solToUsd')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coin_settings');
    }
}
