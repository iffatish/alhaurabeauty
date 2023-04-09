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
        Schema::create('team', function (Blueprint $table) {
            $table->increments('teamId');
            $table->string('teamName');
            $table->foreignId('teamLeader')->references('id')->on('employee')->onDelete('cascade');
            $table->string('teamDesc');
            $table->date('dateCreated');
            $table->integer('memberNum');
            $table->string('teamMember');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
};
