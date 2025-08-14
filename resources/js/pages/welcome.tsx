import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="SciLearn - Junior High Science Learning Management System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
                <header className="mb-8 w-full max-w-7xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="bg-blue-600 p-2 rounded-lg">
                                <span className="text-white text-xl font-bold">🧬</span>
                            </div>
                            <h1 className="text-2xl font-bold text-blue-600 dark:text-blue-400">SciLearn</h1>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-block rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors"
                                >
                                    Go to Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-block rounded-lg border border-blue-300 px-6 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-900"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-block rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors"
                                    >
                                        Sign up
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                <div className="w-full max-w-7xl">
                    <main className="text-center">
                        {/* Hero Section */}
                        <div className="mb-16">
                            <div className="mb-8">
                                <h2 className="text-5xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    🔬 Junior High Science Learning Platform
                                </h2>
                                <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                                    Empowering students, teachers, and administrators with comprehensive science education tools. 
                                    Interactive learning, seamless assessment, and collaborative discovery await!
                                </p>
                            </div>
                            
                            {/* Feature Cards */}
                            <div className="grid md:grid-cols-3 gap-8 mb-12">
                                {/* For Students */}
                                <div className="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow dark:bg-gray-800">
                                    <div className="text-4xl mb-4">👨‍🎓</div>
                                    <h3 className="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">For Students</h3>
                                    <ul className="text-left space-y-2 text-gray-600 dark:text-gray-300">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Interactive learning materials
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Progress tracking & grades
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Quizzes & assignments
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Discussion forums
                                        </li>
                                    </ul>
                                </div>

                                {/* For Teachers */}
                                <div className="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow dark:bg-gray-800">
                                    <div className="text-4xl mb-4">👩‍🏫</div>
                                    <h3 className="text-xl font-bold mb-4 text-purple-600 dark:text-purple-400">For Teachers</h3>
                                    <ul className="text-left space-y-2 text-gray-600 dark:text-gray-300">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Upload multimedia content
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Create interactive quizzes
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Grade & provide feedback
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Live chat with students
                                        </li>
                                    </ul>
                                </div>

                                {/* For Administrators */}
                                <div className="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow dark:bg-gray-800">
                                    <div className="text-4xl mb-4">👨‍💼</div>
                                    <h3 className="text-xl font-bold mb-4 text-indigo-600 dark:text-indigo-400">For Administrators</h3>
                                    <ul className="text-left space-y-2 text-gray-600 dark:text-gray-300">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Course & user management
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            System analytics
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Performance insights
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Platform oversight
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {/* Learning Materials Preview */}
                        <div className="mb-16 bg-white rounded-xl p-8 shadow-lg dark:bg-gray-800">
                            <h3 className="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-200">
                                📚 Rich Learning Materials
                            </h3>
                            <div className="grid md:grid-cols-4 gap-6">
                                <div className="text-center">
                                    <div className="text-4xl mb-3">📝</div>
                                    <h4 className="font-semibold text-gray-800 dark:text-gray-200">Text Content</h4>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Interactive lessons & notes</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-3">🖼️</div>
                                    <h4 className="font-semibold text-gray-800 dark:text-gray-200">Images</h4>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Diagrams & illustrations</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-3">🎥</div>
                                    <h4 className="font-semibold text-gray-800 dark:text-gray-200">Videos</h4>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Experiments & tutorials</p>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-3">🧪</div>
                                    <h4 className="font-semibold text-gray-800 dark:text-gray-200">Interactive</h4>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Quizzes & simulations</p>
                                </div>
                            </div>
                        </div>

                        {/* Communication Features */}
                        <div className="mb-16">
                            <h3 className="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-200">
                                💬 Seamless Communication
                            </h3>
                            <div className="grid md:grid-cols-2 gap-8">
                                <div className="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-8 text-white">
                                    <div className="text-4xl mb-4">💭</div>
                                    <h4 className="text-xl font-bold mb-3">Discussion Forums</h4>
                                    <p className="text-blue-100">
                                        Engage in thoughtful discussions about science topics. 
                                        Ask questions, share insights, and learn collaboratively.
                                    </p>
                                </div>
                                <div className="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-8 text-white">
                                    <div className="text-4xl mb-4">⚡</div>
                                    <h4 className="text-xl font-bold mb-3">Live Chat</h4>
                                    <p className="text-green-100">
                                        Real-time communication between students and teachers. 
                                        Get instant help and participate in live discussions.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Grade Levels */}
                        <div className="mb-16 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-xl p-8 dark:from-purple-900 dark:to-indigo-900">
                            <h3 className="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">
                                🎯 Designed for Junior High Science
                            </h3>
                            <div className="grid md:grid-cols-3 gap-6">
                                <div className="bg-white rounded-lg p-6 shadow dark:bg-gray-800">
                                    <div className="text-3xl mb-3">7️⃣</div>
                                    <h4 className="font-bold text-lg text-gray-800 dark:text-gray-200">Grade 7</h4>
                                    <p className="text-gray-600 dark:text-gray-400">Foundation concepts & basic experiments</p>
                                </div>
                                <div className="bg-white rounded-lg p-6 shadow dark:bg-gray-800">
                                    <div className="text-3xl mb-3">8️⃣</div>
                                    <h4 className="font-bold text-lg text-gray-800 dark:text-gray-200">Grade 8</h4>
                                    <p className="text-gray-600 dark:text-gray-400">Intermediate topics & lab activities</p>
                                </div>
                                <div className="bg-white rounded-lg p-6 shadow dark:bg-gray-800">
                                    <div className="text-3xl mb-3">9️⃣</div>
                                    <h4 className="font-bold text-lg text-gray-800 dark:text-gray-200">Grade 9</h4>
                                    <p className="text-gray-600 dark:text-gray-400">Advanced concepts & research projects</p>
                                </div>
                            </div>
                        </div>

                        {/* Call to Action */}
                        <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-12 text-white">
                            <h3 className="text-4xl font-bold mb-6">Ready to Transform Science Education? 🚀</h3>
                            <p className="text-xl mb-8 text-blue-100">
                                Join thousands of students and teachers already using SciLearn to make science learning engaging, 
                                interactive, and fun. Start your journey today!
                            </p>
                            {!auth.user && (
                                <div className="flex justify-center gap-4">
                                    <Link
                                        href={route('register')}
                                        className="inline-block rounded-lg bg-white px-8 py-4 text-lg font-semibold text-blue-600 hover:bg-gray-100 transition-colors"
                                    >
                                        Get Started Free 🎉
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-block rounded-lg border-2 border-white px-8 py-4 text-lg font-semibold text-white hover:bg-white hover:text-blue-600 transition-colors"
                                    >
                                        Sign In
                                    </Link>
                                </div>
                            )}
                        </div>

                        <footer className="mt-16 text-center text-gray-500 dark:text-gray-400">
                            <p>© 2024 SciLearn - Empowering the next generation of scientists</p>
                        </footer>
                    </main>
                </div>
            </div>
        </>
    );
}