<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatableTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('repeatable_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repeatable_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();

            $table->unique(['repeatable_id', 'locale']);
            $table->foreign('repeatable_id')->references('id')->on('repeatables')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('repeatable_translations');
    }
}
