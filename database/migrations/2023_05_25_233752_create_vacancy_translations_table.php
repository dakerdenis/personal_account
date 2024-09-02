<?php

use App\Models\Vacancy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancy_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vacancy::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('conditions')->nullable();
            $table->text('contacts')->nullable();

            $table->unique(['vacancy_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_translations');
    }
};
