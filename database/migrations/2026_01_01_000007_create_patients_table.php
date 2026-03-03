<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('patient_code');
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamps();
            $table->unique(['hospital_id', 'patient_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
