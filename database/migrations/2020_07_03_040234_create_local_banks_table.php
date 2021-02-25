<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('withdrawal_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('country');
            $table->string('bank_account_number');
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
        Schema::dropIfExists('local_banks');
    }
}
