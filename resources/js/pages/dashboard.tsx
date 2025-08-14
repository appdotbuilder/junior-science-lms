import { AppShell } from '@/components/app-shell';
import { Head } from '@inertiajs/react';

interface Course {
    id: number;
    name: string;
    code: string;
    grade_level: string;
    teacher?: {
        id: number;
        name: string;
    };
    enrollments_count?: number;
    learning_materials_count?: number;
}

interface Quiz {
    id: number;
    title: string;
    available_until: string | null;
    course: {
        name: string;
    };
}

interface Assignment {
    id: number;
    title: string;
    due_date: string;
    course: {
        name: string;
    };
}

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
}

interface DashboardProps {
    user: User;
    role: string;
    enrolledCourses?: Course[];
    upcomingQuizzes?: Quiz[];
    upcomingAssignments?: Assignment[];
    teachingCourses?: Course[];
    recentSubmissions?: Array<{
        id: number;
        student: User;
        assignment: Assignment;
        created_at: string;
    }>;
    totalStudents?: number;
    totalTeachers?: number;
    totalCourses?: number;
    recentActivity?: {
        recentUsers: User[];
        recentCourses: Course[];
    };
    [key: string]: unknown;
}

export default function Dashboard({
    user,
    role,
    enrolledCourses = [],
    upcomingQuizzes = [],
    upcomingAssignments = [],
    teachingCourses = [],
    recentSubmissions = [],
    totalStudents = 0,
    totalTeachers = 0,
    totalCourses = 0,
    recentActivity
}: DashboardProps) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };



    const getRoleEmoji = (userRole: string) => {
        switch (userRole) {
            case 'student': return '👨‍🎓';
            case 'teacher': return '👩‍🏫';
            case 'administrator': return '👨‍💼';
            default: return '👤';
        }
    };

    const getRoleColor = (userRole: string) => {
        switch (userRole) {
            case 'student': return 'text-blue-600 bg-blue-100';
            case 'teacher': return 'text-purple-600 bg-purple-100';
            case 'administrator': return 'text-indigo-600 bg-indigo-100';
            default: return 'text-gray-600 bg-gray-100';
        }
    };

    return (
        <AppShell>
            <Head title="Dashboard - SciLearn" />
            
            <div className="space-y-6">
                {/* Welcome Header */}
                <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-bold mb-2">
                                Welcome back, {user.name}! {getRoleEmoji(role)}
                            </h1>
                            <p className="text-blue-100">
                                {role === 'student' && "Ready to explore science today?"}
                                {role === 'teacher' && "Your students are waiting to learn!"}
                                {role === 'administrator' && "Keep the learning ecosystem thriving!"}
                            </p>
                        </div>
                        <div className={`px-4 py-2 rounded-full text-sm font-semibold ${getRoleColor(role)} bg-white bg-opacity-20 text-white`}>
                            {role.charAt(0).toUpperCase() + role.slice(1)}
                        </div>
                    </div>
                </div>

                {/* Student Dashboard */}
                {role === 'student' && (
                    <>
                        {/* Quick Stats */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">📚</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Enrolled Courses</p>
                                        <p className="text-2xl font-bold text-blue-600">{enrolledCourses.length}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">📝</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Upcoming Quizzes</p>
                                        <p className="text-2xl font-bold text-purple-600">{upcomingQuizzes.length}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">📋</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Due Assignments</p>
                                        <p className="text-2xl font-bold text-orange-600">{upcomingAssignments.length}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {/* My Courses */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">📚</span>
                                    My Courses
                                </h2>
                                {enrolledCourses.length > 0 ? (
                                    <div className="space-y-3">
                                        {enrolledCourses.slice(0, 5).map((course) => (
                                            <div key={course.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h3 className="font-semibold text-gray-800">{course.name}</h3>
                                                    <p className="text-sm text-gray-600">
                                                        {course.code} • Grade {course.grade_level} • {course.teacher?.name}
                                                    </p>
                                                </div>
                                                <div className="text-sm text-blue-600 font-medium">
                                                    Grade {course.grade_level}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No courses enrolled yet</p>
                                )}
                            </div>

                            {/* Upcoming Deadlines */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">⏰</span>
                                    Upcoming Deadlines
                                </h2>
                                <div className="space-y-3">
                                    {upcomingQuizzes.slice(0, 3).map((quiz) => (
                                        <div key={`quiz-${quiz.id}`} className="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                            <div>
                                                <h3 className="font-semibold text-gray-800">📝 {quiz.title}</h3>
                                                <p className="text-sm text-gray-600">{quiz.course.name}</p>
                                            </div>
                                            <div className="text-sm text-purple-600 font-medium">
                                                {quiz.available_until ? formatDate(quiz.available_until) : 'No deadline'}
                                            </div>
                                        </div>
                                    ))}
                                    {upcomingAssignments.slice(0, 3).map((assignment) => (
                                        <div key={`assignment-${assignment.id}`} className="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                            <div>
                                                <h3 className="font-semibold text-gray-800">📋 {assignment.title}</h3>
                                                <p className="text-sm text-gray-600">{assignment.course.name}</p>
                                            </div>
                                            <div className="text-sm text-orange-600 font-medium">
                                                Due {formatDate(assignment.due_date)}
                                            </div>
                                        </div>
                                    ))}
                                    {upcomingQuizzes.length === 0 && upcomingAssignments.length === 0 && (
                                        <p className="text-gray-500 text-center py-4">No upcoming deadlines</p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </>
                )}

                {/* Teacher Dashboard */}
                {role === 'teacher' && (
                    <>
                        {/* Quick Stats */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">👩‍🏫</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Teaching Courses</p>
                                        <p className="text-2xl font-bold text-purple-600">{teachingCourses.length}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">👨‍🎓</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Total Students</p>
                                        <p className="text-2xl font-bold text-blue-600">
                                            {teachingCourses.reduce((acc, course) => acc + (course.enrollments_count || 0), 0)}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">📝</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Pending Submissions</p>
                                        <p className="text-2xl font-bold text-orange-600">{recentSubmissions.length}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {/* My Courses */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">📚</span>
                                    My Courses
                                </h2>
                                {teachingCourses.length > 0 ? (
                                    <div className="space-y-3">
                                        {teachingCourses.map((course) => (
                                            <div key={course.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h3 className="font-semibold text-gray-800">{course.name}</h3>
                                                    <p className="text-sm text-gray-600">
                                                        {course.code} • Grade {course.grade_level}
                                                    </p>
                                                </div>
                                                <div className="text-sm text-purple-600 font-medium">
                                                    {course.enrollments_count || 0} students
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No courses assigned yet</p>
                                )}
                            </div>

                            {/* Recent Activity */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">🔔</span>
                                    Recent Submissions
                                </h2>
                                {recentSubmissions.length > 0 ? (
                                    <div className="space-y-3">
                                        {recentSubmissions.slice(0, 5).map((submission, index) => (
                                            <div key={index} className="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                                <div>
                                                    <h3 className="font-semibold text-gray-800">New Submission</h3>
                                                    <p className="text-sm text-gray-600">Needs grading</p>
                                                </div>
                                                <div className="text-sm text-orange-600 font-medium">
                                                    Pending
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No recent submissions</p>
                                )}
                            </div>
                        </div>
                    </>
                )}

                {/* Administrator Dashboard */}
                {role === 'administrator' && (
                    <>
                        {/* Quick Stats */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">👨‍🎓</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Total Students</p>
                                        <p className="text-2xl font-bold text-blue-600">{totalStudents}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">👩‍🏫</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Total Teachers</p>
                                        <p className="text-2xl font-bold text-purple-600">{totalTeachers}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <div className="flex items-center">
                                    <div className="text-2xl mr-3">📚</div>
                                    <div>
                                        <p className="text-sm text-gray-600">Active Courses</p>
                                        <p className="text-2xl font-bold text-indigo-600">{totalCourses}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {/* Recent Users */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">👥</span>
                                    Recent Users
                                </h2>
                                {recentActivity?.recentUsers && recentActivity.recentUsers.length > 0 ? (
                                    <div className="space-y-3">
                                        {recentActivity.recentUsers.map((user) => (
                                            <div key={user.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div className="flex items-center">
                                                    <span className="mr-3">{getRoleEmoji(user.role)}</span>
                                                    <div>
                                                        <h3 className="font-semibold text-gray-800">{user.name}</h3>
                                                        <p className="text-sm text-gray-600">{user.email}</p>
                                                    </div>
                                                </div>
                                                <div className={`px-2 py-1 rounded-full text-xs font-medium ${getRoleColor(user.role)}`}>
                                                    {user.role}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No recent users</p>
                                )}
                            </div>

                            {/* Recent Courses */}
                            <div className="bg-white rounded-lg p-6 shadow-sm border">
                                <h2 className="text-xl font-bold mb-4 flex items-center">
                                    <span className="mr-2">📚</span>
                                    Recent Courses
                                </h2>
                                {recentActivity?.recentCourses && recentActivity.recentCourses.length > 0 ? (
                                    <div className="space-y-3">
                                        {recentActivity.recentCourses.map((course) => (
                                            <div key={course.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h3 className="font-semibold text-gray-800">{course.name}</h3>
                                                    <p className="text-sm text-gray-600">
                                                        {course.code} • Grade {course.grade_level} • {course.teacher?.name}
                                                    </p>
                                                </div>
                                                <div className="text-sm text-indigo-600 font-medium">
                                                    Grade {course.grade_level}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No recent courses</p>
                                )}
                            </div>
                        </div>
                    </>
                )}
            </div>
        </AppShell>
    );
}