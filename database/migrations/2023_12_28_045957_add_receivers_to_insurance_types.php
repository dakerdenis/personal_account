<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insurance_types', function (Blueprint $table) {
            $table->text('form_recipients')->after('parent_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('insurance_types', function (Blueprint $table) {
            $table->dropColumn('form_recipients');
        });
    }
};
