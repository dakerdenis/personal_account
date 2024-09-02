<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('file_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\File::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();

            $table->unique(['file_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_translations');
    }
};
