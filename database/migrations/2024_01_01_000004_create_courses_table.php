<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Course name');
            $table->text('description')->nullable()->comment('Course description');
            $table->string('code')->unique()->comment('Course code (e.g., SCI-7-01)');
            $table->enum('grade_level', ['7', '8', '9'])->comment('Junior high grade level');
            $table->foreignId('teacher_id')->constrained('users');
            $table->boolean('is_active')->default(true)->comment('Whether course is currently active');
            $table->timestamps();
            
            $table->index(['grade_level', 'is_active']);
            $table->index('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};