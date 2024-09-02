<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->boolean('active')->default(true);
            $table->date('date')->nullable();
            $table->foreignId('staff_id')->nullable()->default(1)->constrained('staff')->nullOnDelete();
            $table->foreignId('gallery_id')->nullable()->constrained("galleries")->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
