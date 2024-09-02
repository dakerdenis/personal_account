<?php

use App\Models\ReportGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\File;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('file_report_group', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ReportGroup::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_report_group');
    }
};
