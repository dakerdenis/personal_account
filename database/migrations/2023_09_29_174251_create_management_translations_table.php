<?php

use App\Models\Manager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manager_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Manager::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();

            $table->unique(['manager_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_translations');
    }
};
