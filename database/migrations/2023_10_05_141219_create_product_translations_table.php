<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->json('statistics')->nullable();
            $table->string('calculator_title')->nullable();
            $table->string('form_title')->nullable();
            $table->string('packages_title')->nullable();
            $table->text('packages_description')->nullable();
            $table->json('banner')->nullable();
            $table->string('insurance_conditions_title')->nullable();


            $table->unique(['product_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
