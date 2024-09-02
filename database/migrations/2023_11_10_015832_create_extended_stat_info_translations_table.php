<?php

use App\Models\ExtendedStatInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('extended_stat_info_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExtendedStatInfo::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique(['extended_stat_info_id', 'locale'], 'ext_uniq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extended_stat_info_translations');
    }
};
