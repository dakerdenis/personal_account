<?php

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('department_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['department_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_translations');
    }
};
