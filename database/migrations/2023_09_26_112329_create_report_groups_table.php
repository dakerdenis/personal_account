<?php

use App\Models\ReportYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ReportYear::class)->constrained()->cascadeOnDelete();
            $table->nestedSet();
            $table->boolean('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_groups');
    }
};
