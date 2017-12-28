<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStNodeIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lr_users', function (Blueprint $table) {
            $table->integer('node_id')->unsigned()->nullable()->after('email');

            $table->foreign('node_id')->references('id')->on('st_nodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lr_users', function (Blueprint $table) {
            $table->dropForeign('node_id');
            // $table->dropColumn('node_id');
        });
    }
}
