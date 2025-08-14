<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample users for each role
        $admin = User::factory()->administrator()->create([
            'name' => 'Admin User',
            'email' => 'admin@scilearn.com',
            'password' => Hash::make('password'),
        ]);

        $teacher1 = User::factory()->teacher()->create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@scilearn.com',
            'password' => Hash::make('password'),
            'bio' => 'Biology teacher with 10+ years of experience in junior high education.',
        ]);

        $teacher2 = User::factory()->teacher()->create([
            'name' => 'Mr. David Chen',
            'email' => 'david.chen@scilearn.com',
            'password' => Hash::make('password'),
            'bio' => 'Chemistry and Physics teacher passionate about hands-on learning.',
        ]);

        $student1 = User::factory()->student()->create([
            'name' => 'Alex Martinez',
            'email' => 'alex.martinez@student.scilearn.com',
            'password' => Hash::make('password'),
        ]);

        $student2 = User::factory()->student()->create([
            'name' => 'Emma Thompson',
            'email' => 'emma.thompson@student.scilearn.com',
            'password' => Hash::make('password'),
        ]);

        // Create additional sample users
        $teachers = User::factory()->teacher()->count(3)->create();
        $students = User::factory()->student()->count(20)->create();

        // Create sample courses
        $courses = [];
        
        $courses[] = Course::factory()->create([
            'name' => 'Grade 7 Life Science',
            'description' => 'Introduction to living organisms, cells, and basic biological processes.',
            'code' => 'LIF-7-01',
            'grade_level' => '7',
            'teacher_id' => $teacher1->id,
        ]);

        $courses[] = Course::factory()->create([
            'name' => 'Grade 8 Physical Science',
            'description' => 'Exploring matter, energy, forces, and motion in the physical world.',
            'code' => 'PHY-8-01',
            'grade_level' => '8',
            'teacher_id' => $teacher2->id,
        ]);

        $courses[] = Course::factory()->create([
            'name' => 'Grade 9 Chemistry Fundamentals',
            'description' => 'Basic chemistry concepts, atomic structure, and chemical reactions.',
            'code' => 'CHE-9-01',
            'grade_level' => '9',
            'teacher_id' => $teacher2->id,
        ]);

        $courses[] = Course::factory()->create([
            'name' => 'Grade 7 Earth Science',
            'description' => 'Study of Earth\'s systems, weather, climate, and geological processes.',
            'code' => 'EAR-7-01',
            'grade_level' => '7',
            'teacher_id' => $teacher1->id,
        ]);

        // Create additional courses with random teachers
        $additionalCourses = Course::factory()->count(6)->create([
            'teacher_id' => fn() => $teachers->random()->id,
        ]);

        $allCourses = collect($courses)->concat($additionalCourses);

        // Enroll students in courses
        $allStudents = collect([$student1, $student2])->concat($students);
        
        foreach ($allStudents as $student) {
            // Enroll each student in 2-4 random courses appropriate for their "grade level"
            $studentCourses = $allCourses->random(random_int(2, 4));
            
            foreach ($studentCourses as $course) {
                CourseEnrollment::factory()->create([
                    'course_id' => $course->id,
                    'student_id' => $student->id,
                ]);
            }
        }
    }
}