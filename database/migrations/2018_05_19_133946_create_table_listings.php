<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weeks');
            $table->integer('passed')->default(0);
            $table->integer('coupons_count');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->boolean('valid')->default(0);
            $table->integer('views')->default(0);
            $table->integer('status')->default(0);
            $table->json('meta_data')->nullable();

            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('instagram_id')->nullable();

            $table->json('social')->nullable();

            $table->timestamps();

            $table->integer('deal_id')->unsigned()->nullable();
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('set null');

            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            // Ads
            $table->boolean('slider_image')->default(0);
            $table->integer('slider_image_id')->unsigned()->nullable();
            $table->foreign('slider_image_id')->references('id')->on('files')->onDelete('set null');

            $table->boolean('menu_image')->default(0);
            $table->integer('menu_image_id')->unsigned()->nullable();
            $table->foreign('menu_image_id')->references('id')->on('files')->onDelete('set null');

            $table->boolean('best_deals')->default(0);
            $table->boolean('category_featured')->default(0);
            $table->boolean('follow_link')->default(0);
            $table->boolean('newsletter')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
