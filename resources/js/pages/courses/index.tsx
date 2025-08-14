import { AppShell } from '@/components/app-shell';
import { Head, Link } from '@inertiajs/react';

interface Course {
    id: number;
    name: string;
    code: string;
    description: string | null;
    grade_level: string;
    teacher: {
        id: number;
        name: string;
        email: string;
    };
    enrollments_count?: number;
    is_active: boolean;
}

interface CoursesIndexProps {
    courses: Course[];
    [key: string]: unknown;
}

export default function CoursesIndex({ courses }: CoursesIndexProps) {
    const getGradeColor = (gradeLevel: string) => {
        switch (gradeLevel) {
            case '7': return 'bg-blue-100 text-blue-800';
            case '8': return 'bg-purple-100 text-purple-800';
            case '9': return 'bg-indigo-100 text-indigo-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AppShell>
            <Head title="Courses - SciLearn" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            📚 My Courses
                        </h1>
                        <p className="text-gray-600 dark:text-gray-300 mt-1">
                            Explore your science courses and learning materials
                        </p>
                    </div>
                </div>

                {/* Courses Grid */}
                {courses.length > 0 ? (
                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        {courses.map((course) => (
                            <div
                                key={course.id}
                                className="bg-white rounded-xl p-6 shadow-sm border hover:shadow-md transition-shadow dark:bg-gray-800 dark:border-gray-700"
                            >
                                {/* Course Header */}
                                <div className="flex items-start justify-between mb-4">
                                    <div className="flex-1">
                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            {course.name}
                                        </h3>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {course.code}
                                        </p>
                                    </div>
                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getGradeColor(course.grade_level)}`}>
                                        Grade {course.grade_level}
                                    </span>
                                </div>

                                {/* Course Description */}
                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {course.description || 'No description available.'}
                                </p>

                                {/* Teacher Info */}
                                <div className="flex items-center mb-4">
                                    <div className="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <span className="text-purple-600 font-semibold text-sm">
                                            {course.teacher.name.split(' ').map(n => n[0]).join('')}
                                        </span>
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium text-gray-900 dark:text-white">
                                            {course.teacher.name}
                                        </p>
                                        <p className="text-xs text-gray-500 dark:text-gray-400">
                                            Instructor
                                        </p>
                                    </div>
                                </div>

                                {/* Course Stats */}
                                <div className="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <span className="flex items-center">
                                        <span className="mr-1">👨‍🎓</span>
                                        {course.enrollments_count || 0} students
                                    </span>
                                    <span className={`flex items-center ${course.is_active ? 'text-green-600' : 'text-red-600'}`}>
                                        <span className="mr-1">{course.is_active ? '✅' : '⚠️'}</span>
                                        {course.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </div>

                                {/* Action Button */}
                                <Link
                                    href={route('courses.show', course.id)}
                                    className="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    View Course
                                    <span className="ml-2">→</span>
                                </Link>
                            </div>
                        ))}
                    </div>
                ) : (
                    /* Empty State */
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">📚</div>
                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            No Courses Found
                        </h3>
                        <p className="text-gray-600 dark:text-gray-400 mb-6">
                            You don't have any courses yet. Contact your administrator to get enrolled in courses.
                        </p>
                    </div>
                )}

                {/* Learning Tips */}
                <div className="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 dark:from-blue-900/20 dark:to-purple-900/20">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        🎯 Learning Tips
                    </h3>
                    <div className="grid md:grid-cols-3 gap-4 text-sm">
                        <div className="flex items-start">
                            <span className="text-blue-500 mr-2 mt-0.5">📝</span>
                            <div>
                                <p className="font-medium text-gray-900 dark:text-white">Stay Organized</p>
                                <p className="text-gray-600 dark:text-gray-400">Keep track of assignments and deadlines</p>
                            </div>
                        </div>
                        <div className="flex items-start">
                            <span className="text-purple-500 mr-2 mt-0.5">🤝</span>
                            <div>
                                <p className="font-medium text-gray-900 dark:text-white">Ask Questions</p>
                                <p className="text-gray-600 dark:text-gray-400">Use forums and chat to get help</p>
                            </div>
                        </div>
                        <div className="flex items-start">
                            <span className="text-green-500 mr-2 mt-0.5">⚡</span>
                            <div>
                                <p className="font-medium text-gray-900 dark:text-white">Practice Regularly</p>
                                <p className="text-gray-600 dark:text-gray-400">Review materials and take quizzes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}