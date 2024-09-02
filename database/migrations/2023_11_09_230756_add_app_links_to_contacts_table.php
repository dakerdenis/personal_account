<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('google_play_link')->nullable()->after('email');
            $table->string('app_store_link')->nullable()->after('google_play_link');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('google_play_link');
            $table->dropColumn('app_store_link');
        });
    }
};
