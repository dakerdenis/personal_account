<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('article_translations', function (Blueprint $table) {
            $table->string('subtitle')->after('seo_keywords')->nullable();
        });

        Schema::table('static_page_translations', function (Blueprint $table) {
            $table->string('subtitle')->after('seo_keywords')->nullable();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->date('end_date')->after('date')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('show_date_on_articles')->after('active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('article_translations', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('show_date_on_articles');
        });

        Schema::table('static_page_translations', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });
    }
};
