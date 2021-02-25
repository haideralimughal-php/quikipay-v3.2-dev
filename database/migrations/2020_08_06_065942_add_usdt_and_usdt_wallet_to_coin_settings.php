<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsdtAndUsdtWalletToCoinSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coin_settings', function (Blueprint $table) {
            $table->boolean('usdt')->default(false)->after("xrp_tag");
            $table->string('usdt_wallet')->nullable()->after("usdt");
            $table->boolean('email_flag')->default(true)->after("pago");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coin_settings', function (Blueprint $table) {
            $table->dropColumn(['usdt',  'usdt_wallet','email_flag']);
        });
    }
}
