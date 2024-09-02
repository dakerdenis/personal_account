<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('slide_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slide_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();

            $table->unique(['slide_id', 'locale']);
            $table->foreign('slide_id')->references('id')->on('slides')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slide_translations');
    }
}
