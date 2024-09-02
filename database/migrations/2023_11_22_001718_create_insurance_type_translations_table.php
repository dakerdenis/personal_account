<?php

use App\Models\InsuranceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InsuranceType::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['insurance_type_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_type_translations');
    }
};
