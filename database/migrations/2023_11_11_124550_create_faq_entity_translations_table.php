<?php

use App\Models\FaqEntity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faq_entity_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FaqEntity::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['faq_entity_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_entity_translations');
    }
};
