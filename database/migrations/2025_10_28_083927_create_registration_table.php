<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->id('registrationid');
            $table->unsignedBigInteger('patientid');
            $table->string('registrationnumber', 30)->unique();
            $table->timestamp('registrationdate');
            $table->string('patientclass', 50)->nullable();
            $table->string('attendingdoctor', 100)->nullable();
            $table->json('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('createduserid');
            
            $table->foreign('patientid')->references('patientid')->on('patient')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration');
    }
}
