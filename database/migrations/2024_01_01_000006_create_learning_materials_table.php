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
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Material title');
            $table->text('description')->nullable()->comment('Material description');
            $table->enum('type', ['text', 'image', 'video', 'document'])->comment('Type of learning material');
            $table->text('content')->nullable()->comment('Text content or file path');
            $table->string('file_path')->nullable()->comment('File path for uploaded materials');
            $table->string('file_type')->nullable()->comment('MIME type of uploaded file');
            $table->bigInteger('file_size')->nullable()->comment('File size in bytes');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->boolean('is_published')->default(true)->comment('Whether material is visible to students');
            $table->integer('sort_order')->default(0)->comment('Display order in course');
            $table->timestamps();
            
            $table->index(['course_id', 'is_published', 'sort_order']);
            $table->index('uploaded_by');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_materials');
    }
};