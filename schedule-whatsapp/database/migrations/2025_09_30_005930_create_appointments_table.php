<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('appointment_id');
            $table->integer('professional_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('appointment_status', 50);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('professional_id')->references('professional_id')->on('professionals');
            $table->foreign('client_id')->references('client_id')->on('clients');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
