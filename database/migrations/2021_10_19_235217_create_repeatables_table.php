<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatablesTable extends Migration
{
    public function up()
    {
        Schema::create('repeatables', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('repeatable');
            $table->text('meta')->nullable();
            $table->unsignedInteger('order_column');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repeatables');
    }
}
