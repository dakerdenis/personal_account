<?php

use App\Models\ExtendedStat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('extended_stat_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExtendedStat::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['extended_stat_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extended_stat_translations');
    }
};
