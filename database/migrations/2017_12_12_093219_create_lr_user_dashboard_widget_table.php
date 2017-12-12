<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrUserDashboardWidgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lr_user_dashboard_widget', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('dashboard_id')->unsigned();
            $table->integer('widget_id')->unsigned();
            $table->integer('x')->unsigned();
            $table->integer('y')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->boolean('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('lr_users');
            $table->foreign('dashboard_id')->references('id')->on('lr_dashboards');
            $table->foreign('widget_id')->references('id')->on('lr_widgets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lr_user_dashboard_widget');
    }
}
