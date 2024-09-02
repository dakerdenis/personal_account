<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPageTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('static_page_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->timestamps();

            $table->unique(['static_page_id', 'locale']);
            $table->foreign('static_page_id')->references('id')->on('static_pages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('static_page_translations');
    }
}
