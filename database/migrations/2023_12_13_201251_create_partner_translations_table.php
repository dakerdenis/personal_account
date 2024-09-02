<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partner_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Partner::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('link')->nullable();

            $table->unique(['partner_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_translations');
    }
};
