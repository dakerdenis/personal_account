<?php

use App\Models\ComplaintStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id()->from(435888);
            $table->foreignIdFor(ComplaintStatus::class)->constrained()->cascadeOnDelete();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('surname', 64);
            $table->string('personal_id', 16);
            $table->string('phone', 24);
            $table->string('email', 64);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
