<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('map');
            $table->dropColumn('map_link');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
        Schema::table('contact_translations', function (Blueprint $table) {
            $table->text('sub_title')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
