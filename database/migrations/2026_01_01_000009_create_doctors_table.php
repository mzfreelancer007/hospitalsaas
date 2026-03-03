<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('license_no')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('fee', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['hospital_id', 'license_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
