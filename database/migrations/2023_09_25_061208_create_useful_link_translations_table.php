<?php

use App\Models\UsefulLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('useful_link_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UsefulLink::class)->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['useful_link_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('useful_link_translations');
    }
};
