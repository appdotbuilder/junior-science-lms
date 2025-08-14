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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question')->comment('Question text');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer'])->comment('Question type');
            $table->json('options')->nullable()->comment('Answer options for multiple choice');
            $table->text('correct_answer')->comment('Correct answer');
            $table->decimal('points', 5, 2)->default(1)->comment('Points awarded for correct answer');
            $table->integer('sort_order')->default(0)->comment('Order of question in quiz');
            $table->timestamps();
            
            $table->index(['quiz_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};