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
        Schema::create('report', function (Blueprint $table) {
            $table->increments('salesReportId');
            $table->string('salesReportType');
            $table->foreignId('employeeId')->references('id')->on('employee')->onDelete('cascade');
            $table->date('reportDate');
            $table->integer('totalSalesQty')->default(0);
            $table->integer('quantitySold')->default(0);
            $table->string('productSold')->nullable();
            $table->decimal('totalSales', 8, 2)->default(0);
            $table->decimal('capital', 8, 2)->default(0);
            $table->decimal('profit', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report');
    }
};
