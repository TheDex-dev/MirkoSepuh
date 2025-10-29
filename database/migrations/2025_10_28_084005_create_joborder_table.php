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
            $table->unsignedBigInteger('laboratoryid');
            $table->unsignedBigInteger('radiologyid');
            $table->string('ordertype', 100)->nullable();
            $table->string('requestingdoctor', 100)->nullable();
            $table->timestamp('orderdate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('status', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestampTz('createdat')->nullable();
            $table->json('updatedat')->nullable();
            $table->json('creteduserid');
            
            // Note: Foreign key constraints are commented out due to circular dependency
            // $table->foreign('laboratoryid')->references('laboratoryid')->on('laboratory');
            // $table->foreign('radiologyid')->references('radiologyid')->on('radiologyorder');
            $table->index('laboratoryid');
            $table->index('radiologyid');
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
