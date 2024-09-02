<?php

use App\Models\InsuranceCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_condition_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InsuranceCondition::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['insurance_condition_id', 'locale'],'insurance_condition_id_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_condition_translations');
    }
};
