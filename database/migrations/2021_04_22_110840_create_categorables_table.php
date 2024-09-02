<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorablesTable extends Migration
{
    public function up()
    {
        Schema::create('categorables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained("categories")->cascadeOnUpdate()->cascadeOnDelete();
            $table->morphs('categorable');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorables');
    }
}
