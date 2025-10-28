<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiologyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiology_orders', function (Blueprint $table) {
            $table->id('rad_id');
            $table->unsignedBigInteger('patient_id');
            $table->text('reg_no')->nullable();
            $table->date('rad_date')->nullable();
            $table->time('rad_time')->nullable();
            $table->text('tx_no')->nullable();
            $table->text('from_unit')->nullable();
            $table->text('doctor')->nullable();
            $table->text('items')->nullable(); // Will store as JSON array
            $table->text('images')->nullable(); // Will store as JSON array
            $table->text('result_text')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radiology_orders');
    }
}
