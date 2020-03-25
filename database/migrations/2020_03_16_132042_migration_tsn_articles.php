<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationTsnArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsn_articles', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('id_article');
            $table->string('title');
            $table->string('image');
            $table->string('description')->nullable()->default('');
            $table->string('link');
            $table->dateTime('date');
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
        Schema::dropIfExists('tsn_articles');
    }
}
