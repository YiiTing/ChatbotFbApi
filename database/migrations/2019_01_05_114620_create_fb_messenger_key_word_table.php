<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbMessengerKeyWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_messenger_key_word', function (Blueprint $table) {
            $table->increments('id');
			$table->string('page_id');
			$table->string('mkw_request');
			$table->string('mkw_response');
			$table->integer('defcus');
			$table->integer('match')->default(0);
			$table->integer('open')->default(1);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fb_messenger_key_word');
    }
}
