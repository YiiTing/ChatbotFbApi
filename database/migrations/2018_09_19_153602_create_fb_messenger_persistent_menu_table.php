<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbMessengerPersistentMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_messenger_persistent_menu', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('page_id');
			$table->string('mpm_title');
			$table->string('mpm_answer')->nullable();
			$table->string('mpm_url')->nullable();
			$table->integer('posted')->default(0);
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
        Schema::dropIfExists('fb_messenger_persistent_menu');
    }
}
