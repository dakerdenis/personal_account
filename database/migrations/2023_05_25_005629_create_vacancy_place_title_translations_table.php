<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancy_place_title_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacancy_place_title_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->unique(['vacancy_place_title_id', 'locale'], 'vpduniq');
            $table->foreign('vacancy_place_title_id', 'vcpct_id')->references('id')->on('vacancy_place_titles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_place_title_translations');
    }
};
