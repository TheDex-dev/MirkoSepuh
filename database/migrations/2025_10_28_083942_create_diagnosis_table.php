<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id('diagnosisid');
            $table->unsignedBigInteger('registrationid');
            $table->string('diagnosistype', 50)->nullable();
            $table->string('diagnosiscode', 20)->nullable();
            $table->text('description');
            $table->json('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('createduserid');
            
            $table->foreign('registrationid')->references('registrationid')->on('registration')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosis');
    }
}
