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
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Forum topic title');
            $table->text('description')->nullable()->comment('Forum description');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_pinned')->default(false)->comment('Whether forum is pinned to top');
            $table->boolean('is_locked')->default(false)->comment('Whether forum is locked for new posts');
            $table->integer('posts_count')->default(0)->comment('Number of posts in forum');
            $table->timestamp('last_post_at')->nullable()->comment('When last post was made');
            $table->timestamps();
            
            $table->index(['course_id', 'is_pinned', 'last_post_at']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};