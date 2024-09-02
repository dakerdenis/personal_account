<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('block_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->unique(['block_id', 'locale']);
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('block_translations');
    }
}
