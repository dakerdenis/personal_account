<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('media_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained("media")->cascadeOnDelete();
            $table->string('locale')->index();
            $table->text('caption')->nullable();
            $table->timestamps();
            $table->unique(['media_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_translations');
    }
}
