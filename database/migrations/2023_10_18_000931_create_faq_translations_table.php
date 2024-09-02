<?php

use App\Models\Faq;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Faq::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->unique(['faq_id', 'locale'], 'faq_id_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_translations');
    }
};
