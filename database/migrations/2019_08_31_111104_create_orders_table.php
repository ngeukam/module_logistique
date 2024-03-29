<?php
/**
 * File name: 2019_08_31_111104_create_orders_table.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_status_id')->nullable()->default('1')->unsigned();
            $table->double('tax', 5, 2)->nullable()->default(0);
            $table->double('delivery_fee', 5, 2)->nullable()->default(0);
            $table->text('hint')->nullable()->default('');
            $table->boolean('active')->default(1);
            $table->integer('driver_id')->nullable()->unsigned();
            $table->integer('delivery_address_id')->nullable()->unsigned();
            $table->integer('payment_id')->nullable()->unsigned();
            $table->integer('order_locations_statuses_id')->nullable()->default('1')->unsigned();
            $table->integer('type_truck')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('delivery_address_id')->references('id')->on('delivery_addresses')->onDelete('set null')->onUpdate('set null');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null')->onUpdate('set null');
            $table->foreign('order_locations_statuses_id')->references('id')->on('order_locations_statuses')->onDelete('cascade');
            $table->foreign('type_truck')->references('id')->on('trucks')->onDelete('cascade')->onUpdate('cascade');


            $table->string('type_product')->nullable()->default('');
            $table->double('masse', 60, 2)->nullable()->default(0);
            $table->string('departure_address')->nullable()->default('');
            $table->string('arrival_address')->nullable()->default('');
            $table->integer('number_truck')->nullable()->unsigned();
            $table->date('departure_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('recipient_name')->nullable()->default('');
            $table->string('recipient_surname')->nullable()->default('');
            $table->string('recipient_phone')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
