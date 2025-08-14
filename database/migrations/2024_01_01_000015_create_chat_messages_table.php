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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message')->comment('Chat message content');
            $table->enum('type', ['text', 'image', 'file'])->default('text')->comment('Message type');
            $table->string('file_path')->nullable()->comment('File path for attachments');
            $table->string('file_name')->nullable()->comment('Original file name');
            $table->boolean('is_read')->default(false)->comment('Whether message has been read');
            $table->timestamps();
            
            $table->index(['course_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};