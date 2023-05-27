<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_information', function (Blueprint $table) {
            $table->increments('orderId');
            $table->string('custName');
            $table->string('custPhoneNum');
            $table->string('deliveryAddress');
            $table->string('deliveryMethod');
            $table->string('paymentMethod');
            $table->decimal('additionalCost', 8, 2)->default(0);
            $table->decimal('orderPrice', 8, 2);
            $table->date('orderDate');
            $table->integer('totalItems');
            $table->foreignId('employeeId')->references('id')->on('employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_information');
    }
};
