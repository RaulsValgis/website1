<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->index();
            $table->string('city', 100)->nullable();
            $table->integer('population')->unsigned()->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
};