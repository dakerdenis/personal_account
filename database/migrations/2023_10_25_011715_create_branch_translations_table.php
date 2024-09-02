<?php

use App\Models\Branch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('branch_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('address')->nullable();
            $table->text('work_hours')->nullable();
            $table->timestamps();

            $table->unique(['branch_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_translations');
    }
};
