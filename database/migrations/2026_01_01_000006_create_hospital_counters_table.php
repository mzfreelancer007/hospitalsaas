<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hospital_counters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->unsignedBigInteger('current_value')->default(0);
            $table->timestamps();
            $table->unique(['hospital_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_counters');
    }
};
