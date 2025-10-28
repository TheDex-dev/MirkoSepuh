<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAllergyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergy', function (Blueprint $table) {
            $table->id('allergyid');
            $table->unsignedBigInteger('patientid');
            $table->string('allergyname', 255);
            $table->date('recordeddate')->default(DB::raw('CURRENT_DATE'));
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
        Schema::dropIfExists('allergy');
    }
}
