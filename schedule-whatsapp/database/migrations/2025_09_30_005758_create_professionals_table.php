<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->increments('professional_id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('full_name');
            $table->string('display_name');
            $table->string('whatsapp_number', 50)->unique();
            $table->string('email')->unique();
            $table->text('company_description')->nullable();
            $table->string('working_days')->nullable();
            $table->time('work_start_time');
            $table->time('work_end_time');
            $table->string('account_status', 20);
            $table->string('plan', 20);
            $table->timestamps();
            
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professionals');
    }
}
