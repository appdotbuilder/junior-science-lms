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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->text('content')->nullable()->comment('Text submission content');
            $table->string('file_path')->nullable()->comment('Submitted file path');
            $table->string('file_name')->nullable()->comment('Original file name');
            $table->string('file_type')->nullable()->comment('File MIME type');
            $table->bigInteger('file_size')->nullable()->comment('File size in bytes');
            $table->decimal('grade', 5, 2)->nullable()->comment('Grade received');
            $table->text('feedback')->nullable()->comment('Teacher feedback');
            $table->foreignId('graded_by')->nullable()->constrained('users');
            $table->timestamp('graded_at')->nullable()->comment('When assignment was graded');
            $table->boolean('is_late')->default(false)->comment('Whether submission was late');
            $table->timestamps();
            
            $table->unique(['assignment_id', 'student_id']);
            $table->index(['student_id', 'created_at']);
            $table->index('graded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};