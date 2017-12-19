<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateColumnToUserDashboardWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lr_user_dashboard_widget', function (Blueprint $table) {
            $table->string('template')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lr_user_dashboard_widget', function (Blueprint $table) {
            $table->dropColumn('template');
        });
    }
}
