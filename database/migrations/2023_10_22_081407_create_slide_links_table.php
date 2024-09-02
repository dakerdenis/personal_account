<?php

use App\Models\Slide;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slide_links', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Slide::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order_column')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slide_links');
    }
};
