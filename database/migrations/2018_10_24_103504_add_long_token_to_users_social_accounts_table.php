<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLongTokenToUsersSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_social_accounts', function (Blueprint $table) {
            $table->string('long_provider_token')->after('provider_token');
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
			$table->dropColumn('long_provider_token');
        });
    }
}
