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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Assignment title');
            $table->text('description')->comment('Assignment description and instructions');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->decimal('max_points', 5, 2)->default(100)->comment('Maximum points for assignment');
            $table->timestamp('due_date')->comment('Assignment due date');
            $table->boolean('allow_late_submission')->default(true)->comment('Whether to accept late submissions');
            $table->boolean('is_published')->default(false)->comment('Whether assignment is visible to students');
            $table->timestamps();
            
            $table->index(['course_id', 'is_published']);
            $table->index('created_by');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};