<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feature_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ProductFeature::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order_column');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_lines');
    }
};
