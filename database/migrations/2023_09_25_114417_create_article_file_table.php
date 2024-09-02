<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_file', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Article::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\File::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_file');
    }
};
