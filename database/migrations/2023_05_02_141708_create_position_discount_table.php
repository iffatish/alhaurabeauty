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
        Schema::create('position_discount', function (Blueprint $table) {
            $table->increments('discountId');
            $table->float('discountHQ');
            $table->float('discountMasterLeader');
            $table->float('discountLeader');
            $table->float('discountMasterStockist');
            $table->float('discountStockist');
            $table->float('discountMasterAgent');
            $table->float('discountAgent');
            $table->float('discountDropship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position_discount');
    }
};
