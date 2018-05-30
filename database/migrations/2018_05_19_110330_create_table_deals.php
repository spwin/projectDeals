<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('link');
            $table->string('maps_link')->nullable();
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 10, 2)->nullable();
            $table->integer('status')->default(0);
            $table->json('seo')->nullable();
            $table->json('location')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('set null');

            $table->integer('map_id')->unsigned()->nullable();
            $table->foreign('map_id')->references('id')->on('files')->onDelete('set null');

            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
