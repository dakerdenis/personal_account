<?php

use App\Models\ComplaintStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaint_status_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ComplaintStatus::class)->constrained()->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('title', 64)->nullable();

            $table->unique(['complaint_status_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_status_translations');
    }
};
