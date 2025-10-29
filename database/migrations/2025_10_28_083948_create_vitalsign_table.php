<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalsignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vitalsign', function (Blueprint $table) {
            $table->id('vitalid');
            $table->unsignedBigInteger('patientid');
            $table->string('measurementname', 50);
            $table->string('measurementvalue', 50);
            $table->timestamp('measurementtime');
            $table->json('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('createduserid');
            
            $table->foreign('patientid')->references('patientid')->on('patient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vitalsign');
    }
}
