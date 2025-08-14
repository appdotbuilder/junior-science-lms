<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\LearningMaterial;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LmsController extends Controller
{
    /**
     * Display the main LMS dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            // Show welcome page with LMS overview
            return Inertia::render('welcome');
        }

        // Get dashboard data based on user role
        $dashboardData = $this->getDashboardData($user);
        
        return Inertia::render('dashboard', $dashboardData);
    }

    /**
     * Get dashboard data based on user role.
     *
     * @param User $user
     * @return array
     */
    protected function getDashboardData(User $user): array
    {
        $data = [
            'user' => $user,
            'role' => $user->role,
        ];

        if ($user->isStudent()) {
            $enrolledCourses = $user->enrolledCourses()
                ->with(['teacher', 'learningMaterials' => function ($query) {
                    $query->where('is_published', true)->orderBy('sort_order');
                }])
                ->where('is_active', true)
                ->get();

            $upcomingQuizzes = Quiz::whereHas('course.enrollments', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })
                ->where('is_published', true)
                ->where(function ($q) {
                    $q->whereNull('available_from')
                      ->orWhere('available_from', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('available_until')
                      ->orWhere('available_until', '>=', now());
                })
                ->with('course')
                ->orderBy('available_until')
                ->limit(5)
                ->get();

            $upcomingAssignments = Assignment::whereHas('course.enrollments', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })
                ->where('is_published', true)
                ->where('due_date', '>', now())
                ->with('course')
                ->orderBy('due_date')
                ->limit(5)
                ->get();

            $data += [
                'enrolledCourses' => $enrolledCourses,
                'upcomingQuizzes' => $upcomingQuizzes,
                'upcomingAssignments' => $upcomingAssignments,
            ];

        } elseif ($user->isTeacher()) {
            $teachingCourses = $user->teachingCourses()
                ->with(['enrollments.student', 'learningMaterials', 'quizzes', 'assignments'])
                ->where('is_active', true)
                ->get();

            $recentSubmissions = Assignment::whereHas('course', function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })
                ->with(['submissions' => function ($query) {
                    $query->whereNull('grade')->latest()->limit(10);
                }, 'submissions.student', 'course'])
                ->get()
                ->pluck('submissions')
                ->flatten()
                ->sortByDesc('created_at')
                ->take(5);

            $data += [
                'teachingCourses' => $teachingCourses,
                'recentSubmissions' => $recentSubmissions,
            ];

        } elseif ($user->isAdministrator()) {
            $totalStudents = User::where('role', 'student')->count();
            $totalTeachers = User::where('role', 'teacher')->count();
            $totalCourses = Course::where('is_active', true)->count();
            $recentActivity = $this->getRecentActivity();

            $data += [
                'totalStudents' => $totalStudents,
                'totalTeachers' => $totalTeachers,
                'totalCourses' => $totalCourses,
                'recentActivity' => $recentActivity,
            ];
        }

        return $data;
    }

    /**
     * Get recent system activity for administrators.
     *
     * @return array
     */
    protected function getRecentActivity(): array
    {
        $recentUsers = User::latest()->limit(5)->get();
        $recentCourses = Course::with('teacher')->latest()->limit(5)->get();
        
        return [
            'recentUsers' => $recentUsers,
            'recentCourses' => $recentCourses,
        ];
    }
}