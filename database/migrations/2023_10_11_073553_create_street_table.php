<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('streets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street', 100);
            $table->integer('city_id')
                  ->unsigned()
                  ->index();
            $table->integer('country_id')
                  ->unsigned()
                  ->index();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }
};