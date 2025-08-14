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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->json('answers')->comment('Student answers');
            $table->decimal('score', 5, 2)->nullable()->comment('Quiz score percentage');
            $table->integer('points_earned')->default(0)->comment('Total points earned');
            $table->integer('total_points')->default(0)->comment('Total possible points');
            $table->timestamp('started_at')->comment('When quiz was started');
            $table->timestamp('completed_at')->nullable()->comment('When quiz was completed');
            $table->boolean('is_graded')->default(false)->comment('Whether quiz has been graded');
            $table->timestamps();
            
            $table->index(['quiz_id', 'student_id']);
            $table->index(['student_id', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};