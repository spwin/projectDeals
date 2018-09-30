<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->boolean('used')->default(false);
            $table->dateTime('used_at')->nullable();

            $table->dateTime('valid_until');

            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->integer('deal_id')->unsigned()->nullable();
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('set null');

            $table->integer('listing_id')->unsigned()->nullable();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('set null');

            $table->integer('rotation_id')->unsigned()->nullable();
            $table->foreign('rotation_id')->references('id')->on('rotation')->onDelete('set null');

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
        Schema::dropIfExists('coupons');
    }
}
