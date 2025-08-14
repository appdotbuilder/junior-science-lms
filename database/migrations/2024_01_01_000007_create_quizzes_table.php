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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Quiz title');
            $table->text('description')->nullable()->comment('Quiz description');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->integer('time_limit')->nullable()->comment('Time limit in minutes');
            $table->integer('max_attempts')->default(1)->comment('Maximum attempts allowed');
            $table->decimal('passing_score', 5, 2)->default(70)->comment('Minimum score to pass');
            $table->boolean('is_published')->default(false)->comment('Whether quiz is available to students');
            $table->timestamp('available_from')->nullable()->comment('When quiz becomes available');
            $table->timestamp('available_until')->nullable()->comment('When quiz expires');
            $table->timestamps();
            
            $table->index(['course_id', 'is_published']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};