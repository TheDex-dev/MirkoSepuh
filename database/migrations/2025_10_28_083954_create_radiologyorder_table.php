<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiologyorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiologyorder', function (Blueprint $table) {
            $table->id('orderid');
            $table->unsignedBigInteger('registrationid');
            $table->timestamp('orderdate');
            $table->string('procedurename', 255);
            $table->string('requestingdoctor', 100)->nullable();
            $table->string('status', 50)->default('Ordered');
            $table->text('resultsummary')->nullable();
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
        Schema::dropIfExists('radiologyorder');
    }
}
