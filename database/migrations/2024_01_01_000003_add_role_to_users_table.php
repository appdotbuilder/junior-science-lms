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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'teacher', 'administrator'])->default('student')->after('email');
            $table->string('student_id')->nullable()->after('role')->comment('Student ID for students');
            $table->string('employee_id')->nullable()->after('student_id')->comment('Employee ID for teachers and administrators');
            $table->text('bio')->nullable()->after('employee_id')->comment('User biography');
            
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id', 'employee_id', 'bio']);
        });
    }
};