<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyQuotesTable extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('currency_pair', 255);
            $table->decimal('price', 15, 4);  
            $table->timestamps();
        });
    }

}
