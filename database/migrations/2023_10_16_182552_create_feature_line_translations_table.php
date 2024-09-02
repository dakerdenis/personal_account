<?php

use App\Models\FeatureLine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feature_line_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FeatureLine::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['feature_line_id', 'locale'], 'feature_line_id_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_line_translations');
    }
};
