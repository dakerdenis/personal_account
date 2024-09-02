<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained("contacts")->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('working_hours')->nullable();
            $table->timestamps();

            $table->unique(['contact_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_translations');
    }
}
