<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJoborderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joborder', function (Blueprint $table) {
            $table->id('joborderid');
            $table->unsignedBigInteger('registration');
            $table->string('ordertype', 100)->nullable();
            $table->string('requestingdoctor', 100)->nullable();
            $table->timestamp('orderdate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('status', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('creteduserid');
            
            $table->foreign('registration')->references('registrationid')->on('registration')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joborder');
    }
}
