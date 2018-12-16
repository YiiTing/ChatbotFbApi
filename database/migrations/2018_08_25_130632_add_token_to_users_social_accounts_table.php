<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenToUsersSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_social_accounts', function (Blueprint $table) {
            $table->string('provider_token')->after('provider');
			$table->string('provider_user_gender', 10)->after('provider_token')->nullable();
			$table->string('provider_user_birthday')->after('provider_user_gender')->nullable();
			$table->string('provider_user_age_range')->after('provider_user_birthday')->nullable();
			$table->string('provider_user_link')->after('provider_user_age_range')->nullable();
			$table->text('provider_user_likes')->after('provider_user_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_social_accounts', function (Blueprint $table) {
            $table->dropColumn(['provider_token', 'provider_user_gender', 'provider_user_birthday', 'provider_user_age_range', 'provider_user_link' ,'provider_user_likes']);
        });
    }
}
