<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonNoteController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\AchievementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/category/{category}', [CourseController::class, 'category'])->name('courses.category');

// Learning Paths
Route::get('/learning-paths', [LearningPathController::class, 'index'])->name('learning_paths.index');
Route::get('/learning-paths/{learningPath}', [LearningPathController::class, 'show'])->name('learning_paths.show');

// Certificate Verification (Public)
Route::get('/certificates/verify/{certificateNumber}', [AchievementController::class, 'publicCertificate'])->name('certificates.public');

/*
|--------------------------------------------------------------------------
| Dashboard Route
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    
    $user = Auth::user();
    
    // Redirect berdasarkan role
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('instructor')) {
        return redirect()->route('instructor.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }
    
    // Fallback jika tidak ada role
    return redirect('/')->with('info', 'Please contact admin to assign your role.');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::delete('/courses/{course}/unenroll', [EnrollmentController::class, 'destroy'])->name('courses.unenroll');

    // Lessons
    Route::get('/courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::post('/courses/{course}/lessons/{lesson}/watch-time', [LessonController::class, 'updateWatchTime'])->name('lessons.watch-time');
    Route::post('/courses/{course}/lessons/{lesson}/toggle-complete', [LessonController::class, 'toggleComplete'])->name('lessons.toggle-complete');
    Route::get('/courses/{course}/lessons/{lesson}/download/{filename}', [LessonController::class, 'download'])->name('lessons.download');
    Route::post('/courses/{course}/lessons/{lesson}/save-notes', [LessonController::class, 'saveNotes'])->name('lessons.save-notes');
    
    // Quizzes
    Route::get('/courses/{course}/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/courses/{course}/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/answer/{question}', [QuizController::class, 'saveAnswer'])->name('quizzes.save-answer');
    Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/review', [QuizController::class, 'review'])->name('quizzes.review');
    Route::post('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/result', [QuizController::class, 'result'])->name('quizzes.result');
    Route::post('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/update-time', [QuizController::class, 'updateTime'])->name('quizzes.update-time');
    Route::post('/courses/{course}/quizzes/{quiz}/reset', [QuizController::class, 'resetQuiz'])->name('quizzes.reset');
    
    // Lesson Notes
    Route::get('/courses/{course}/lessons/{lesson}/notes', [LessonNoteController::class, 'show'])->name('lesson.notes.show');
    Route::post('/courses/{course}/lessons/{lesson}/notes', [LessonNoteController::class, 'store'])->name('lesson.notes.store');
    Route::delete('/courses/{course}/lessons/{lesson}/notes', [LessonNoteController::class, 'destroy'])->name('lesson.notes.destroy');
    
    // Learning Paths
    Route::post('/learning-paths/{learningPath}/enroll', [LearningPathController::class, 'enroll'])->name('learning_paths.enroll');
    Route::get('/learning-paths/{learningPath}/dashboard', [LearningPathController::class, 'dashboard'])->name('learning_paths.dashboard');

    // Achievements & Certificates
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::get('/achievements/badges', [AchievementController::class, 'showAchievements'])->name('achievements.badges');
    Route::get('/certificates/{id}', [AchievementController::class, 'showCertificate'])->name('certificates.show');
    Route::get('/certificates/{id}/download', [AchievementController::class, 'downloadCertificate'])->name('certificates.download');
    Route::get('/certificates/{id}/share', [AchievementController::class, 'shareOptions'])->name('certificates.share');
    
    // Bookmarks
    Route::get('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::get('/bookmarks/{bookmark}/edit', [App\Http\Controllers\BookmarkController::class, 'edit'])->name('bookmarks.edit');
    Route::put('/bookmarks/{bookmark}', [App\Http\Controllers\BookmarkController::class, 'update'])->name('bookmarks.update');
    Route::delete('/bookmarks/{bookmark}', [App\Http\Controllers\BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::post('/bookmarks/{bookmark}/toggle-favorite', [App\Http\Controllers\BookmarkController::class, 'toggleFavorite'])->name('bookmarks.toggle-favorite');
    Route::post('/bookmarks/{bookmark}/update-notes', [App\Http\Controllers\BookmarkController::class, 'updateNotes'])->name('bookmarks.update-notes');
    
    // Bookmark Categories
    Route::get('/bookmark-categories/create', [App\Http\Controllers\BookmarkController::class, 'createCategory'])->name('bookmark-categories.create');
    Route::post('/bookmark-categories', [App\Http\Controllers\BookmarkController::class, 'storeCategory'])->name('bookmark-categories.store');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
    
    // Analytics routes
    Route::get('/analytics', [App\Http\Controllers\Student\AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/chart-data', [App\Http\Controllers\Student\AnalyticsController::class, 'getChartData'])->name('analytics.chart-data');
    
    // Payment routes
    Route::get('/payments', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments');
    Route::get('/payments/{payment}/invoice', [App\Http\Controllers\Student\PaymentController::class, 'showInvoice'])->name('payments.invoice');
    Route::get('/payments/{payment}/download-invoice', [App\Http\Controllers\Student\PaymentController::class, 'downloadInvoice'])->name('payments.download-invoice');
    
    // Profile routes
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [App\Http\Controllers\Student\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [App\Http\Controllers\Student\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/avatar/delete', [App\Http\Controllers\Student\ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Instructor\DashboardController::class, 'index'])->name('dashboard');
    
    // Course Management
    Route::resource('courses', App\Http\Controllers\Instructor\CourseController::class);
    Route::post('/courses/{course}/publish', [App\Http\Controllers\Instructor\CourseController::class, 'publish'])->name('courses.publish');
    Route::post('/courses/{course}/unpublish', [App\Http\Controllers\Instructor\CourseController::class, 'unpublish'])->name('courses.unpublish');
    
    // Section Management
    Route::resource('courses.sections', App\Http\Controllers\Instructor\SectionController::class)->except(['create', 'edit', 'show']);
    
    // Lesson Management
    Route::resource('courses.lessons', App\Http\Controllers\Instructor\LessonController::class)->except(['create', 'show']);
    
    // Students
    Route::get('/students', [App\Http\Controllers\Instructor\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{user}', [App\Http\Controllers\Instructor\StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{user}/progress', [App\Http\Controllers\Instructor\StudentController::class, 'progress'])->name('students.progress');
    Route::post('/students/message', [App\Http\Controllers\Instructor\StudentController::class, 'message'])->name('students.message');
    Route::post('/students/unenroll', [App\Http\Controllers\Instructor\StudentController::class, 'unenroll'])->name('students.unenroll');

    // Course Analytics
    Route::get('/courses/{course}/analytics', [App\Http\Controllers\Instructor\AnalyticsController::class, 'show'])->name('courses.analytics');
    Route::get('/courses/{course}/chart-data', [App\Http\Controllers\Instructor\AnalyticsController::class, 'getChartData'])->name('courses.chart-data');

    // Assignments routes
    Route::resource('courses.assignments', App\Http\Controllers\Instructor\AssignmentController::class);
    Route::get('courses/{course}/assignments/{assignment}/submissions/{submission}', [App\Http\Controllers\Instructor\AssignmentController::class, 'viewSubmission'])->name('courses.assignments.submissions.show');
    Route::post('courses/{course}/assignments/{assignment}/submissions/{submission}/grade', [App\Http\Controllers\Instructor\AssignmentController::class, 'gradeSubmission'])->name('courses.assignments.submissions.grade');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Settings Routes
    Route::get('/settings/platform', [App\Http\Controllers\Admin\SettingController::class, 'platform'])->name('settings.platform');
    Route::get('/settings/payment', [App\Http\Controllers\Admin\SettingController::class, 'payment'])->name('settings.payment');
    Route::get('/settings/email', [App\Http\Controllers\Admin\SettingController::class, 'email'])->name('settings.email');
    Route::post('/settings/update', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/test-email', [App\Http\Controllers\Admin\SettingController::class, 'testEmail'])->name('settings.test-email');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::put('/users/{user}/update-roles', [App\Http\Controllers\Admin\UserController::class, 'updateRoles'])->name('users.update-roles');
    
    // Course Management
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::put('/courses/{course}/status', [App\Http\Controllers\Admin\CourseController::class, 'updateStatus'])->name('courses.update-status');
    Route::get('/courses-analytics', [App\Http\Controllers\Admin\CourseController::class, 'analytics'])->name('courses.analytics');
    
    // Category Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Learning Path Management
    Route::resource('learning-paths', App\Http\Controllers\Admin\LearningPathController::class);
    Route::get('/learning-paths/{learningPath}/stages', [App\Http\Controllers\Admin\LearningPathController::class, 'stages'])->name('learning-paths.stages');
    Route::post('/learning-paths/{learningPath}/stages', [App\Http\Controllers\Admin\LearningPathController::class, 'storeStage'])->name('learning-paths.stages.store');
    Route::put('/learning-paths/{learningPath}/stages/{stage}', [App\Http\Controllers\Admin\LearningPathController::class, 'updateStage'])->name('learning-paths.stages.update');
    Route::delete('/learning-paths/{learningPath}/stages/{stage}', [App\Http\Controllers\Admin\LearningPathController::class, 'destroyStage'])->name('learning-paths.stages.destroy');
    Route::post('/learning-paths/{learningPath}/stages/{stage}/courses', [App\Http\Controllers\Admin\LearningPathController::class, 'addCourse'])->name('learning-paths.stages.courses.add');
    Route::delete('/learning-paths/{learningPath}/stages/{stage}/courses/{course}', [App\Http\Controllers\Admin\LearningPathController::class, 'removeCourse'])->name('learning-paths.stages.courses.remove');
    Route::post('/learning-paths/{learningPath}/publish', [App\Http\Controllers\Admin\LearningPathController::class, 'publish'])->name('learning-paths.publish');
    Route::post('/learning-paths/{learningPath}/archive', [App\Http\Controllers\Admin\LearningPathController::class, 'archive'])->name('learning-paths.archive');
    
    // Certificate Management
    Route::get('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create', [App\Http\Controllers\Admin\CertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'store'])->name('certificates.store');
    Route::delete('/certificates/{certificate}', [App\Http\Controllers\Admin\CertificateController::class, 'destroy'])->name('certificates.destroy');
    
    // Email Templates
    Route::get('/settings/email-templates', [App\Http\Controllers\Admin\SettingController::class, 'emailTemplates'])->name('settings.email-templates');
    Route::get('/settings/email-templates/{template}', [App\Http\Controllers\Admin\SettingController::class, 'editEmailTemplate'])->name('settings.email-templates.edit');
    Route::put('/settings/email-templates/{template}', [App\Http\Controllers\Admin\SettingController::class, 'updateEmailTemplate'])->name('settings.email-templates.update');
});

/*
|--------------------------------------------------------------------------
| Public Course Routes
|--------------------------------------------------------------------------
*/

// Route instructor profile
Route::get('/instructor/{id}', [CourseController::class, 'instructor'])->name('courses.instructor');

// Discussion Forum Routes
Route::prefix('discussions')->name('discussions.')->group(function () {
    Route::get('/', [App\Http\Controllers\DiscussionController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [App\Http\Controllers\DiscussionController::class, 'indexByCategory'])->name('category');
    Route::get('/course/{course:slug}', [App\Http\Controllers\DiscussionController::class, 'indexByCourse'])->name('course');
    Route::get('/create', [App\Http\Controllers\DiscussionController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/', [App\Http\Controllers\DiscussionController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/{discussion:slug}', [App\Http\Controllers\DiscussionController::class, 'show'])->name('show');
    Route::get('/{discussion:slug}/edit', [App\Http\Controllers\DiscussionController::class, 'edit'])->name('edit')->middleware('auth');
    Route::put('/{discussion:slug}', [App\Http\Controllers\DiscussionController::class, 'update'])->name('update')->middleware('auth');
    Route::delete('/{discussion:slug}', [App\Http\Controllers\DiscussionController::class, 'destroy'])->name('destroy')->middleware('auth');
    Route::post('/{discussion:slug}/vote', [App\Http\Controllers\DiscussionController::class, 'vote'])->name('vote')->middleware('auth');
    
    // Discussion replies
    Route::post('/{discussion:slug}/replies', [App\Http\Controllers\DiscussionReplyController::class, 'store'])->name('replies.store')->middleware('auth');
    Route::get('/replies/{reply}/edit', [App\Http\Controllers\DiscussionReplyController::class, 'edit'])->name('replies.edit')->middleware('auth');
    Route::put('/replies/{reply}', [App\Http\Controllers\DiscussionReplyController::class, 'update'])->name('replies.update')->middleware('auth');
    Route::delete('/replies/{reply}', [App\Http\Controllers\DiscussionReplyController::class, 'destroy'])->name('replies.destroy')->middleware('auth');
    Route::post('/replies/{reply}/solution', [App\Http\Controllers\DiscussionReplyController::class, 'markAsSolution'])->name('replies.solution')->middleware('auth');
    Route::post('/replies/{reply}/vote', [App\Http\Controllers\DiscussionReplyController::class, 'vote'])->name('replies.vote')->middleware('auth');
});

// Student routes
Route::group(['middleware' => ['auth', 'student'], 'prefix' => 'student', 'as' => 'student.'], function () {
    // Assignments routes for students
    Route::get('courses/{course}/assignments', [App\Http\Controllers\Student\SubmissionController::class, 'index'])->name('courses.assignments.index');
    Route::get('courses/{course}/assignments/{assignment}', [App\Http\Controllers\Student\SubmissionController::class, 'show'])->name('courses.assignments.show');
    Route::get('courses/{course}/assignments/{assignment}/submit', [App\Http\Controllers\Student\SubmissionController::class, 'create'])->name('courses.assignments.submit');
    Route::post('courses/{course}/assignments/{assignment}/submit', [App\Http\Controllers\Student\SubmissionController::class, 'store'])->name('courses.assignments.store');
    Route::get('courses/{course}/assignments/{assignment}/submissions/{submission}/download', [App\Http\Controllers\Student\SubmissionController::class, 'download'])->name('courses.assignments.submissions.download');
});

// Instructor Auth Routes
Route::prefix('instructor')->name('instructor.')->group(function () {
    Route::get('login', [App\Http\Controllers\Instructor\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Instructor\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Instructor\AuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';

// Tambahkan di bagian bawah file
Route::get('/debug-tables', function () {
    $output = [
        'quiz_question_options' => Schema::hasTable('quiz_question_options') ? Schema::getColumnListing('quiz_question_options') : 'Not exists',
        'quiz_options' => Schema::hasTable('quiz_options') ? Schema::getColumnListing('quiz_options') : 'Not exists',
        'quiz_answers_columns' => Schema::hasTable('quiz_answers') ? Schema::getColumnListing('quiz_answers') : 'Not exists',
        'quiz_question_options_count' => \DB::table('quiz_question_options')->count(),
        'first_option' => \DB::table('quiz_question_options')->first(),
        'foreign_keys' => collect(\DB::select("
            SELECT 
                TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
            FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
                REFERENCED_TABLE_NAME IS NOT NULL
                AND TABLE_NAME = 'quiz_answers' AND COLUMN_NAME = 'selected_option_id'
        "))
    ];
    return response()->json($output);
});

// Bookmark Debug Route
Route::post('bookmark-debug', [App\Http\Controllers\BookmarkDebugController::class, 'store'])->name('bookmark.debug');

// Contact Routes
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');