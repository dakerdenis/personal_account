<?php

use App\Models\SlideLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slide_link_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SlideLink::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();

            $table->unique(['slide_link_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slide_link_translations');
    }
};
