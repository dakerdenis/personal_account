<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->string('slug');
            $table->boolean('is_mega_menu')->default(false);
            $table->boolean('selected')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('navigation_id');
            $table->foreignId('staff_id')->nullable()->default(1)->constrained('staff')->nullOnDelete();
            $table->timestamps();

            $table->foreign('navigation_id')->references('id')->on('navigations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
