<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $courses = $user->enrolledCourses()
                ->with(['teacher', 'enrollments'])
                ->where('is_active', true)
                ->get();
        } elseif ($user->isTeacher()) {
            $courses = $user->teachingCourses()
                ->with(['teacher', 'enrollments'])
                ->where('is_active', true)
                ->get();
        } else {
            // Administrator sees all courses
            $courses = Course::with(['teacher', 'enrollments'])
                ->where('is_active', true)
                ->get();
        }

        return Inertia::render('courses/index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $teachers = User::where('role', 'teacher')->get(['id', 'name', 'email']);
        
        return Inertia::render('courses/create', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Store a newly created course.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        
        // Check if user has access to this course
        if ($user->isStudent()) {
            $enrollment = $course->enrollments()
                ->where('student_id', $user->id)
                ->first();
            
            if (!$enrollment) {
                abort(403, 'You are not enrolled in this course.');
            }
        } elseif ($user->isTeacher() && $course->teacher_id !== $user->id) {
            abort(403, 'You do not have access to this course.');
        }

        $course->load([
            'teacher',
            'enrollments.student',
            'learningMaterials' => function ($query) use ($user) {
                if ($user->isStudent()) {
                    $query->published();
                }
                $query->orderBy('sort_order');
            },
            'quizzes' => function ($query) use ($user) {
                if ($user->isStudent()) {
                    $query->available();
                }
                $query->orderBy('created_at');
            },
            'assignments' => function ($query) use ($user) {
                if ($user->isStudent()) {
                    $query->published();
                }
                $query->orderBy('due_date');
            },
            'forums' => function ($query) {
                $query->orderBy('is_pinned', 'desc')
                      ->orderBy('last_post_at', 'desc');
            }
        ]);

        return Inertia::render('courses/show', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the course.
     */
    public function edit(Course $course)
    {
        $teachers = User::where('role', 'teacher')->get(['id', 'name', 'email']);
        
        return Inertia::render('courses/edit', [
            'course' => $course,
            'teachers' => $teachers
        ]);
    }

    /**
     * Update the specified course.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}