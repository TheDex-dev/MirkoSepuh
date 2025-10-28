<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id('result_id');
            $table->unsignedBigInteger('lab_id');
            $table->text('group_name')->nullable();
            $table->text('test_name')->nullable();
            $table->timestamp('result_date')->nullable();
            $table->text('flag')->nullable();
            $table->text('result_value')->nullable();
            $table->text('unit')->nullable();
            $table->text('standard_value')->nullable();
            $table->text('result_comment')->nullable();
            $table->text('result_note')->nullable();
            $table->timestamps();

            $table->foreign('lab_id')
                  ->references('lab_id')
                  ->on('lab_orders')
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
        Schema::dropIfExists('lab_results');
    }
}
