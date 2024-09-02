<?php

use App\Models\Block;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('extended_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Block::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order_column');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extended_stats');
    }
};
