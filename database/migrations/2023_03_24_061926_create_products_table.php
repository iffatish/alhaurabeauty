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
        Schema::create('product', function (Blueprint $table) {
            $table->increments('productId');
            $table->string('productName', 100);
            $table->string('productImage', 100);
            $table->decimal('productSellPrice', 8, 2);
            $table->decimal('priceHQ', 8, 2);
            $table->decimal('priceMasterLeader', 8, 2);
            $table->decimal('priceLeader', 8, 2);
            $table->decimal('priceMasterStockist', 8, 2);
            $table->decimal('priceStockist', 8, 2);
            $table->decimal('priceMasterAgent', 8, 2);
            $table->decimal('priceAgent', 8, 2);
            $table->decimal('priceDropship', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
