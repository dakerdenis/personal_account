<?php

use App\Models\ReportGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_group_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ReportGroup::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['report_group_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_group_translations');
    }
};
