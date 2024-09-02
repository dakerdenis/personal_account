<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('article_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained("articles")->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('bottom_text')->nullable();
            $table->timestamps();
            $table->unique(['article_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_translations');
    }
}
