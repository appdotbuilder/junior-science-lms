<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Biology', 'Chemistry', 'Physics', 'Earth Science', 'Life Science'];
        $subject = $this->faker->randomElement($subjects);
        $gradeLevel = $this->faker->randomElement(['7', '8', '9']);
        
        return [
            'name' => "Grade {$gradeLevel} {$subject}",
            'description' => $this->faker->paragraph(3),
            'code' => $subject[0] . $subject[1] . $subject[2] . '-' . $gradeLevel . '-' . $this->faker->unique()->numberBetween(10, 99),
            'grade_level' => $gradeLevel,
            'teacher_id' => User::factory()->teacher(),
            'is_active' => true,
        ];
    }
}