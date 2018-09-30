<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->json('data')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('previous')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotation');
    }
}
