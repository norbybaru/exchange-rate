<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rate_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency_iso', 5)->index();
            $table->float('rate', 5);
            $table->string('base_currency_iso', 5)->index();
            $table->timestamp('source_updated_at');
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
        Schema::dropIfExists('exchange_rate_histories');
    }
};
