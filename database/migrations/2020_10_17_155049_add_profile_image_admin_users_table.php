<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileImageAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET sql_mode = ''");
        Schema::table('admin_users', function (Blueprint $table) {
            //
            $table->text('profile_image')->after('password')->nullable();
            $table->text('user_role')->after('profile_image')->nullable();
            $table->text('short_description')->after('user_role')->nullable();

        });
        DB::statement("SET sql_mode = 'STRICT_TRANS_TABLES'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            //
             $table->dropColumn(['profile_image']);
              $table->dropColumn(['user_role']);
               $table->dropColumn(['short_description']);

        });
    }
}
