<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockablesTable extends Migration
{
    public function up()
    {
        Schema::create('blockables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id');
            $table->nullableMorphs('blockable');
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blockables');
    }
}
