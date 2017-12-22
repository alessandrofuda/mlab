<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lr_subscriptions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('plant_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('sensor_id')->unsigned()->nullable();
            $table->integer('actuator_id')->unsigned()->nullable();  // always nullable!
            $table->timestamps();

            // FK
            $table->foreign('user_id')->references('id')->on('lr_users');
            $table->foreign('customer_id')->references('id')->on('el_customers');
            $table->foreign('plant_id')->references('id')->on('el_plants');
            $table->foreign('department_id')->references('id')->on('el_departments');
            $table->foreign('sensor_id')->references('id')->on('el_sensors');
            $table->foreign('actuator_id')->references('id')->on('el_actuators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lr_subscriptions');
    }
}
