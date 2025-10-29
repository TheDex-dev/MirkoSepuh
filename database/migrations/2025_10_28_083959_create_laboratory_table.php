<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratory', function (Blueprint $table) {
            $table->id('laboratoryid');
            $table->unsignedBigInteger('patientid');
            $table->timestamp('orderdate');
            $table->string('procedurename', 255);
            $table->string('requestingdoctor', 100)->nullable();
            $table->string('status', 50)->default('Ordered');
            $table->text('resultsummary')->nullable();
            $table->string('examname', 50)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('resultcomment', 50)->nullable();
            $table->string('resultnote', 50)->nullable();
            $table->json('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('createduserid');
            $table->unsignedBigInteger('joboredrid');
            
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
        Schema::dropIfExists('laboratory');
    }
}
