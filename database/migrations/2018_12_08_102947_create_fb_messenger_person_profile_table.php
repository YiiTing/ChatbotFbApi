<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbMessengerPersonProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_messenger_person_profile', function (Blueprint $table) {
            $table->increments('id');
			$table->string('page_id');
			$table->string('psid');
			$table->string('mpp_first_name');
			$table->string('mpp_last_name');
			$table->string('mpp_profile_pic');
			$table->string('mpp_locale')->nullable();
			$table->string('mpp_gender', 10)->nullable();
			$table->integer('like')->default(0);
			$table->integer('bot')->default(1);
			$table->integer('block')->default(0);
			$table->bigInteger('interaction');
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
        Schema::dropIfExists('fb_messenger_person_profile');
    }
}
