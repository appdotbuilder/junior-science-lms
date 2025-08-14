import { AppShell } from '@/components/app-shell';
import { Head } from '@inertiajs/react';

interface Teacher {
    id: number;
    name: string;
    email: string;
    bio?: string;
}

interface Student {
    id: number;
    name: string;
    email: string;
}

interface LearningMaterial {
    id: number;
    title: string;
    description: string | null;
    type: 'text' | 'image' | 'video' | 'document';
    content: string | null;
    file_path: string | null;
    is_published: boolean;
    sort_order: number;
}

interface Quiz {
    id: number;
    title: string;
    description: string | null;
    time_limit: number | null;
    max_attempts: number;
    passing_score: number;
    is_published: boolean;
    available_from: string | null;
    available_until: string | null;
}

interface Assignment {
    id: number;
    title: string;
    description: string;
    max_points: number;
    due_date: string;
    allow_late_submission: boolean;
    is_published: boolean;
}

interface Forum {
    id: number;
    title: string;
    description: string | null;
    is_pinned: boolean;
    is_locked: boolean;
    posts_count: number;
    last_post_at: string | null;
}

interface Course {
    id: number;
    name: string;
    code: string;
    description: string | null;
    grade_level: string;
    teacher: Teacher;
    enrollments: Array<{ student: Student }>;
    learning_materials: LearningMaterial[];
    quizzes: Quiz[];
    assignments: Assignment[];
    forums: Forum[];
    is_active: boolean;
}

interface CourseShowProps {
    course: Course;
    [key: string]: unknown;
}

export default function CourseShow({ course }: CourseShowProps) {
    const getTypeIcon = (type: string) => {
        switch (type) {
            case 'text': return '📝';
            case 'image': return '🖼️';
            case 'video': return '🎥';
            case 'document': return '📄';
            default: return '📄';
        }
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };



    return (
        <AppShell>
            <Head title={`${course.name} - SciLearn`} />
            
            <div className="space-y-8">
                {/* Course Header */}
                <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-white">
                    <div className="flex items-start justify-between mb-4">
                        <div>
                            <div className="flex items-center gap-3 mb-2">
                                <h1 className="text-3xl font-bold">{course.name}</h1>
                                <span className={`px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white`}>
                                    Grade {course.grade_level}
                                </span>
                            </div>
                            <p className="text-blue-100 text-lg mb-2">{course.code}</p>
                            {course.description && (
                                <p className="text-blue-100 max-w-3xl leading-relaxed">
                                    {course.description}
                                </p>
                            )}
                        </div>
                    </div>
                    
                    {/* Teacher Info */}
                    <div className="flex items-center">
                        <div className="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <span className="text-white font-semibold">
                                {course.teacher.name.split(' ').map(n => n[0]).join('')}
                            </span>
                        </div>
                        <div>
                            <p className="font-semibold text-lg">{course.teacher.name}</p>
                            <p className="text-blue-100">Instructor • {course.enrollments.length} students enrolled</p>
                        </div>
                    </div>
                </div>

                {/* Course Navigation Tabs */}
                <div className="bg-white rounded-lg border overflow-hidden">
                    <div className="border-b border-gray-200">
                        <nav className="flex space-x-8 px-6">
                            <a href="#materials" className="py-4 px-1 border-b-2 border-blue-500 font-medium text-blue-600">
                                📚 Materials ({course.learning_materials.length})
                            </a>
                            <a href="#quizzes" className="py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700">
                                📝 Quizzes ({course.quizzes.length})
                            </a>
                            <a href="#assignments" className="py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700">
                                📋 Assignments ({course.assignments.length})
                            </a>
                            <a href="#forums" className="py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700">
                                💬 Forums ({course.forums.length})
                            </a>
                        </nav>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-8">
                        {/* Learning Materials */}
                        <section id="materials">
                            <h2 className="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span className="mr-2">📚</span>
                                Learning Materials
                            </h2>
                            
                            {course.learning_materials.length > 0 ? (
                                <div className="space-y-4">
                                    {course.learning_materials.map((material) => (
                                        <div key={material.id} className="bg-white rounded-lg p-6 border hover:shadow-sm transition-shadow">
                                            <div className="flex items-start justify-between">
                                                <div className="flex items-start space-x-3 flex-1">
                                                    <span className="text-2xl">
                                                        {getTypeIcon(material.type)}
                                                    </span>
                                                    <div className="flex-1">
                                                        <h3 className="font-semibold text-gray-900 mb-1">
                                                            {material.title}
                                                        </h3>
                                                        {material.description && (
                                                            <p className="text-gray-600 text-sm mb-2">
                                                                {material.description}
                                                            </p>
                                                        )}
                                                        <div className="flex items-center space-x-4 text-xs text-gray-500">
                                                            <span>Type: {material.type}</span>
                                                            {material.is_published ? (
                                                                <span className="text-green-600">✅ Published</span>
                                                            ) : (
                                                                <span className="text-yellow-600">⏳ Draft</span>
                                                            )}
                                                        </div>
                                                    </div>
                                                </div>
                                                <button className="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 bg-gray-50 rounded-lg">
                                    <div className="text-4xl mb-3">📚</div>
                                    <p className="text-gray-600">No learning materials available yet.</p>
                                </div>
                            )}
                        </section>

                        {/* Quizzes */}
                        <section id="quizzes">
                            <h2 className="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span className="mr-2">📝</span>
                                Quizzes
                            </h2>
                            
                            {course.quizzes.length > 0 ? (
                                <div className="space-y-4">
                                    {course.quizzes.map((quiz) => (
                                        <div key={quiz.id} className="bg-white rounded-lg p-6 border hover:shadow-sm transition-shadow">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <h3 className="font-semibold text-gray-900 mb-2">
                                                        {quiz.title}
                                                    </h3>
                                                    {quiz.description && (
                                                        <p className="text-gray-600 text-sm mb-3">
                                                            {quiz.description}
                                                        </p>
                                                    )}
                                                    <div className="flex items-center space-x-6 text-sm text-gray-500">
                                                        {quiz.time_limit && (
                                                            <span>⏱️ {quiz.time_limit} minutes</span>
                                                        )}
                                                        <span>🎯 {quiz.passing_score}% to pass</span>
                                                        <span>🔄 {quiz.max_attempts} attempt{quiz.max_attempts !== 1 ? 's' : ''}</span>
                                                        {quiz.available_until && (
                                                            <span>⏰ Due: {formatDate(quiz.available_until)}</span>
                                                        )}
                                                    </div>
                                                </div>
                                                <button className="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                                                    Take Quiz
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 bg-gray-50 rounded-lg">
                                    <div className="text-4xl mb-3">📝</div>
                                    <p className="text-gray-600">No quizzes available yet.</p>
                                </div>
                            )}
                        </section>

                        {/* Assignments */}
                        <section id="assignments">
                            <h2 className="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span className="mr-2">📋</span>
                                Assignments
                            </h2>
                            
                            {course.assignments.length > 0 ? (
                                <div className="space-y-4">
                                    {course.assignments.map((assignment) => (
                                        <div key={assignment.id} className="bg-white rounded-lg p-6 border hover:shadow-sm transition-shadow">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <h3 className="font-semibold text-gray-900 mb-2">
                                                        {assignment.title}
                                                    </h3>
                                                    <p className="text-gray-600 text-sm mb-3">
                                                        {assignment.description}
                                                    </p>
                                                    <div className="flex items-center space-x-6 text-sm text-gray-500">
                                                        <span>📊 {assignment.max_points} points</span>
                                                        <span>📅 Due: {formatDate(assignment.due_date)}</span>
                                                        {assignment.allow_late_submission && (
                                                            <span className="text-green-600">✅ Late submission allowed</span>
                                                        )}
                                                    </div>
                                                </div>
                                                <button className="px-4 py-2 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors">
                                                    View Assignment
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 bg-gray-50 rounded-lg">
                                    <div className="text-4xl mb-3">📋</div>
                                    <p className="text-gray-600">No assignments available yet.</p>
                                </div>
                            )}
                        </section>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Course Info */}
                        <div className="bg-white rounded-lg p-6 border">
                            <h3 className="font-semibold text-gray-900 mb-4">Course Information</h3>
                            <div className="space-y-3 text-sm">
                                <div>
                                    <span className="text-gray-600">Code:</span>
                                    <span className="ml-2 font-medium">{course.code}</span>
                                </div>
                                <div>
                                    <span className="text-gray-600">Grade Level:</span>
                                    <span className="ml-2 font-medium">Grade {course.grade_level}</span>
                                </div>
                                <div>
                                    <span className="text-gray-600">Students:</span>
                                    <span className="ml-2 font-medium">{course.enrollments.length} enrolled</span>
                                </div>
                                <div>
                                    <span className="text-gray-600">Status:</span>
                                    <span className={`ml-2 font-medium ${course.is_active ? 'text-green-600' : 'text-red-600'}`}>
                                        {course.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {/* Teacher Bio */}
                        {course.teacher.bio && (
                            <div className="bg-white rounded-lg p-6 border">
                                <h3 className="font-semibold text-gray-900 mb-4">About Your Teacher</h3>
                                <p className="text-gray-600 text-sm leading-relaxed">
                                    {course.teacher.bio}
                                </p>
                            </div>
                        )}

                        {/* Discussion Forums */}
                        <div className="bg-white rounded-lg p-6 border">
                            <h3 className="font-semibold text-gray-900 mb-4 flex items-center">
                                <span className="mr-2">💬</span>
                                Discussion Forums
                            </h3>
                            {course.forums.length > 0 ? (
                                <div className="space-y-3">
                                    {course.forums.slice(0, 3).map((forum) => (
                                        <div key={forum.id} className="p-3 bg-gray-50 rounded-lg">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <h4 className="font-medium text-gray-900 text-sm mb-1">
                                                        {forum.is_pinned && '📌 '}{forum.title}
                                                    </h4>
                                                    <div className="flex items-center space-x-3 text-xs text-gray-500">
                                                        <span>{forum.posts_count} posts</span>
                                                        {forum.last_post_at && (
                                                            <span>Last: {formatDate(forum.last_post_at)}</span>
                                                        )}
                                                    </div>
                                                </div>
                                                {forum.is_locked && (
                                                    <span className="text-yellow-600 text-sm">🔒</span>
                                                )}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-500 text-sm">No forums yet</p>
                            )}
                        </div>

                        {/* Quick Actions */}
                        <div className="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg p-6">
                            <h3 className="font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div className="space-y-2">
                                <button className="w-full text-left px-3 py-2 text-sm bg-white rounded-lg hover:bg-gray-50 transition-colors">
                                    💬 Join Class Chat
                                </button>
                                <button className="w-full text-left px-3 py-2 text-sm bg-white rounded-lg hover:bg-gray-50 transition-colors">
                                    📊 View My Grades
                                </button>
                                <button className="w-full text-left px-3 py-2 text-sm bg-white rounded-lg hover:bg-gray-50 transition-colors">
                                    📈 Track Progress
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}