<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_sessions', function (Blueprint $table) {
            $table->increments('session_id');
            $table->integer('client_id')->unsigned();
            $table->integer('professional_id')->unsigned();
            $table->string('current_state');
            $table->jsonb('context_data')->nullable();
            $table->timestamp('last_message_at');
            $table->timestamps();
            
            $table->foreign('client_id')->references('client_id')->on('clients');
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
        Schema::dropIfExists('conversation_sessions');
    }
}
