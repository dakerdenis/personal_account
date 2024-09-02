<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_item_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->timestamps();

            $table->unique(['menu_item_id', 'locale']);
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_translations');
    }
}
