<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoborderdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joborderdetail', function (Blueprint $table) {
            $table->id('joborderdetailid');
            $table->unsignedBigInteger('joborderid');
            $table->string('servicecode', 50)->nullable();
            $table->string('servicename', 255);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->text('resultvalue')->nullable();
            $table->string('status', 50)->nullable();
            $table->json('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('createduserid');
            
            $table->foreign('joborderid')->references('joborderid')->on('joborder')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joborderdetail');
    }
}
