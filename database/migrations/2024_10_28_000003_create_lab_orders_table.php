<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->id('lab_id');
            $table->unsignedBigInteger('patient_id');
            $table->text('reg_no')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->text('tx_no')->nullable();
            $table->text('from_unit')->nullable();
            $table->text('doctor')->nullable();
            $table->boolean('urgent')->default(false);
            $table->text('items')->nullable(); // Will store as JSON array
            $table->text('price')->nullable();
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
        Schema::dropIfExists('lab_orders');
    }
}
