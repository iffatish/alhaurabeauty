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
        Schema::create('restock_information', function (Blueprint $table) {
            $table->increments('restockId');
            $table->integer('batchNo');
            $table->string('restockFrom');
            $table->string('restockPaymentMethod');
            $table->date('restockDate');
            $table->decimal('restockPrice', 8, 2);
            $table->string('currentPosition');
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
        Schema::dropIfExists('restock_information');
    }
};
