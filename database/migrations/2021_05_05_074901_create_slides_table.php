<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_column');
            $table->unsignedBigInteger('slider_id');
            $table->foreignId('staff_id')->nullable()->default(1)->constrained('staff')->nullOnDelete();
            $table->timestamps();

            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
