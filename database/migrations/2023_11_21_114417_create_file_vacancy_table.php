<?php

use App\Models\Product;
use App\Models\Vacancy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('file_vacancy', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\File::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Vacancy::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_vacancy');
    }
};
