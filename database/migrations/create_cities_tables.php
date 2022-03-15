<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Papposilene\Geodata\GeodataRegistrar;

class CreateCitiesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geodata__cities', function (Blueprint $table) {
            $table->id();
            // Administrative layers
            $table->string('country_cca3', 3);
            $table->string('state', 255)->nullable(); // adm1name
            // City data
            $table->string('name', 255);
            $table->point('lat')->nullable();
            $table->point('lon')->nullable();
            // Extra data in JSON
            $table->json('postcodes')->nullable();
            $table->json('extra')->nullable();
            // Internal data
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_cca3')->references('id')->on('geodata__countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geodata__cities');
    }
}
