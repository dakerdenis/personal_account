<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('extended_stat_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ExtendedStat::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order_column');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extended_stat_infos');
    }
};
