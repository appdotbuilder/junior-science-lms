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
        Schema::create('participation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recorded_by')->constrained('users');
            $table->date('date')->comment('Date of participation');
            $table->enum('type', ['attendance', 'discussion', 'activity', 'behavior'])->comment('Type of participation');
            $table->decimal('points', 5, 2)->default(0)->comment('Points awarded');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            $table->index(['course_id', 'student_id', 'date']);
            $table->index(['student_id', 'type']);
            $table->index('recorded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participation_records');
    }
};