<?php

use App\Models\Gallery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->foreignIdFor(Gallery::class)->nullable()->constrained()->nullOnDelete();
        });
        Schema::table('static_page_translations', function (Blueprint $table) {
            $table->text('bottom_text')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn('gallery_id');
        });

        Schema::table('static_page_translations', function (Blueprint $table) {
            $table->dropColumn('bottom_text');
        });
    }
};
