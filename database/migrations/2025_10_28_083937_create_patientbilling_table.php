<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePatientbillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patientbilling', function (Blueprint $table) {
            $table->id('billingid');
            $table->unsignedBigInteger('registrationid')->unique();
            $table->decimal('plafond', 15, 2)->default(0);
            $table->decimal('totalbilling', 15, 2)->default(0);
            $table->decimal('difference', 15, 2)->default(0);
            $table->timestamp('lastupdated')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('patientbilling');
    }
}
