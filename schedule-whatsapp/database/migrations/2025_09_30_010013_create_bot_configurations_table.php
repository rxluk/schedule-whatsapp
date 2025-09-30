<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_configurations', function (Blueprint $table) {
            $table->increments('config_id');
            $table->integer('professional_id')->unsigned()->unique();
            $table->text('welcome_message');
            $table->jsonb('bot_menu_structure_json')->nullable();
            $table->text('appointment_success_message');
            $table->text('appointment_canceled_message');
            $table->text('no_available_times_message');
            $table->text('payment_info_text')->nullable();
            $table->timestamps();
            
            $table->foreign('professional_id')->references('professional_id')->on('professionals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_configurations');
    }
}
