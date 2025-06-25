<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\LearningPath;
use App\Models\PathStage;
use App\Models\PathStageCourse;
use App\Models\PathAchievement;
use App\Models\Course;

class LearningPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we have courses to work with
        if (Course::count() === 0) {
            $this->createSampleCourses();
        }

        // Get available courses
        $webCourses = Course::where('title', 'like', '%Web%')->orWhere('title', 'like', '%HTML%')
            ->orWhere('title', 'like', '%CSS%')->orWhere('title', 'like', '%JavaScript%')
            ->orWhere('title', 'like', '%PHP%')->orWhere('title', 'like', '%Laravel%')
            ->get();
        
        $mobileCourses = Course::where('title', 'like', '%Mobile%')->orWhere('title', 'like', '%Android%')
            ->orWhere('title', 'like', '%iOS%')->orWhere('title', 'like', '%Flutter%')
            ->orWhere('title', 'like', '%React Native%')->get();
        
        $dataCourses = Course::where('title', 'like', '%Data%')->orWhere('title', 'like', '%Python%')
            ->orWhere('title', 'like', '%SQL%')->orWhere('title', 'like', '%Analytics%')
            ->orWhere('title', 'like', '%Machine Learning%')->get();

        // If we still don't have enough courses, create some for each path
        if ($webCourses->count() < 5) {
            $webCourses = $webCourses->merge($this->createCoursesForPath('Web Development'));
        }
        
        if ($mobileCourses->count() < 5) {
            $mobileCourses = $mobileCourses->merge($this->createCoursesForPath('Mobile Development'));
        }
        
        if ($dataCourses->count() < 5) {
            $dataCourses = $dataCourses->merge($this->createCoursesForPath('Data Science'));
        }

        // Create Web Development Learning Path
        $this->createWebDevelopmentPath($webCourses);

        // Create Mobile Development Learning Path
        $this->createMobileDevelopmentPath($mobileCourses);

        // Create Data Science Learning Path
        $this->createDataSciencePath($dataCourses);
    }

    private function createSampleCourses()
    {
        $courseData = [
            // Web Development Courses
            ['title' => 'HTML & CSS Fundamentals', 'status' => 'published'],
            ['title' => 'JavaScript Basics', 'status' => 'published'],
            ['title' => 'Advanced JavaScript', 'status' => 'published'],
            ['title' => 'PHP for Beginners', 'status' => 'published'],
            ['title' => 'Laravel Framework', 'status' => 'published'],
            ['title' => 'Vue.js Essentials', 'status' => 'published'],
            ['title' => 'React.js Fundamentals', 'status' => 'published'],
            ['title' => 'Full Stack Web Development', 'status' => 'published'],
            
            // Mobile Development Courses
            ['title' => 'Android Development Basics', 'status' => 'published'],
            ['title' => 'iOS App Development', 'status' => 'published'],
            ['title' => 'Flutter Cross-Platform Development', 'status' => 'published'],
            ['title' => 'React Native Masterclass', 'status' => 'published'],
            ['title' => 'Mobile UI/UX Design', 'status' => 'published'],
            
            // Data Science Courses
            ['title' => 'Introduction to Python', 'status' => 'published'],
            ['title' => 'Data Analysis with Pandas', 'status' => 'published'],
            ['title' => 'SQL for Data Analysis', 'status' => 'published'],
            ['title' => 'Machine Learning Fundamentals', 'status' => 'published'],
            ['title' => 'Data Visualization Techniques', 'status' => 'published'],
        ];

        foreach ($courseData as $course) {
            Course::create([
                'title' => $course['title'],
                'slug' => Str::slug($course['title']),
                'description' => 'This is a sample course description for ' . $course['title'],
                'requirements' => ['Basic computer knowledge', 'Internet connection'],
                'objectives' => ['Learn the fundamentals', 'Build practical projects', 'Master key concepts'],
                'price' => rand(0, 100) * 1000,
                'status' => $course['status'],
                'level' => ['beginner', 'intermediate', 'advanced'][rand(0, 2)],
                'user_id' => 1,
                'duration' => rand(1, 10) * 60, // in minutes
            ]);
        }
    }

    private function createCoursesForPath($pathType)
    {
        $courses = collect();
        
        if ($pathType === 'Web Development') {
            $courses = collect([
                Course::create([
                    'title' => 'HTML & CSS Fundamentals',
                    'slug' => 'html-css-fundamentals',
                    'description' => 'Learn the basics of web development with HTML and CSS',
                    'requirements' => ['No prior experience needed', 'Basic computer skills'],
                    'objectives' => ['Build your first website', 'Understand HTML structure', 'Style with CSS'],
                    'price' => 0,
                    'status' => 'published',
                    'level' => 'beginner',
                    'user_id' => 1,
                    'duration' => 300, // 5 hours in minutes
                ]),
                Course::create([
                    'title' => 'JavaScript Essentials',
                    'slug' => 'javascript-essentials',
                    'description' => 'Learn JavaScript programming from scratch',
                    'requirements' => ['HTML & CSS knowledge', 'Basic programming logic'],
                    'objectives' => ['Master JavaScript basics', 'DOM manipulation', 'Create interactive websites'],
                    'price' => 75000,
                    'status' => 'published',
                    'level' => 'beginner',
                    'user_id' => 1,
                    'duration' => 480, // 8 hours in minutes
                ]),
                Course::create([
                    'title' => 'PHP & MySQL Development',
                    'slug' => 'php-mysql-development',
                    'description' => 'Build dynamic websites with PHP and MySQL',
                    'requirements' => ['HTML & CSS knowledge', 'Basic programming concepts'],
                    'objectives' => ['Server-side programming', 'Database integration', 'Build dynamic websites'],
                    'price' => 85000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1, 
                    'duration' => 720, // 12 hours in minutes
                ]),
                Course::create([
                    'title' => 'Laravel Web Development',
                    'slug' => 'laravel-web-development',
                    'description' => 'Master the Laravel PHP framework',
                    'requirements' => ['PHP knowledge', 'MVC pattern understanding', 'Basic OOP concepts'],
                    'objectives' => ['Build Laravel applications', 'Implement authentication', 'Use Eloquent ORM'],
                    'price' => 120000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 900, // 15 hours in minutes
                ]),
                Course::create([
                    'title' => 'Full Stack Development',
                    'slug' => 'full-stack-development',
                    'description' => 'Become a full stack developer with LAMP stack',
                    'requirements' => ['Frontend skills', 'Backend knowledge', 'Database experience'],
                    'objectives' => ['Integrate frontend and backend', 'Deploy applications', 'Architecture best practices'],
                    'price' => 150000,
                    'status' => 'published',
                    'level' => 'advanced',
                    'user_id' => 1,
                    'duration' => 1200, // 20 hours in minutes
                ]),
            ]);
        } elseif ($pathType === 'Mobile Development') {
            $courses = collect([
                Course::create([
                    'title' => 'Introduction to Mobile Development',
                    'slug' => 'intro-to-mobile-development',
                    'description' => 'Learn the basics of mobile app development',
                    'requirements' => ['Basic programming knowledge', 'Computer with development environment'],
                    'objectives' => ['Understand mobile platforms', 'Mobile UI basics', 'App architecture concepts'],
                    'price' => 0,
                    'status' => 'published',
                    'level' => 'beginner',
                    'user_id' => 1,
                    'duration' => 240, // 4 hours in minutes
                ]),
                Course::create([
                    'title' => 'Android Development Fundamentals',
                    'slug' => 'android-development-fundamentals',
                    'description' => 'Learn Android app development with Kotlin',
                    'requirements' => ['Basic programming knowledge', 'Java or Kotlin familiarity helpful'],
                    'objectives' => ['Build Android apps', 'Use Android Studio', 'Implement Material Design'],
                    'price' => 95000,
                    'status' => 'published',
                    'level' => 'beginner',
                    'user_id' => 1,
                    'duration' => 600, // 10 hours in minutes
                ]),
                Course::create([
                    'title' => 'iOS Development with Swift',
                    'slug' => 'ios-development-with-swift',
                    'description' => 'Create iOS applications using Swift',
                    'requirements' => ['Mac computer with Xcode', 'Basic programming knowledge'],
                    'objectives' => ['Swift programming', 'Build iOS applications', 'Use UIKit and SwiftUI'],
                    'price' => 105000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 720, // 12 hours in minutes
                ]),
                Course::create([
                    'title' => 'Flutter & Dart Development',
                    'slug' => 'flutter-dart-development',
                    'description' => 'Create cross-platform mobile apps with Flutter',
                    'requirements' => ['Basic programming knowledge', 'Object-oriented programming concepts'],
                    'objectives' => ['Learn Dart programming', 'Build Flutter UIs', 'Deploy to iOS and Android'],
                    'price' => 125000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 900, // 15 hours in minutes
                ]),
                Course::create([
                    'title' => 'Advanced Mobile UI/UX Design',
                    'slug' => 'advanced-mobile-ui-ux',
                    'description' => 'Design beautiful and intuitive mobile interfaces',
                    'requirements' => ['Basic design knowledge', 'Mobile development experience'],
                    'objectives' => ['Create engaging mobile UIs', 'User-centered design principles', 'Prototyping techniques'],
                    'price' => 95000,
                    'status' => 'published',
                    'level' => 'advanced',
                    'user_id' => 1,
                    'duration' => 480, // 8 hours in minutes
                ]),
            ]);
        } elseif ($pathType === 'Data Science') {
            $courses = collect([
                Course::create([
                    'title' => 'Python for Data Science',
                    'slug' => 'python-for-data-science',
                    'description' => 'Learn Python programming for data analysis',
                    'requirements' => ['No prior programming experience needed', 'Basic math knowledge'],
                    'objectives' => ['Python programming basics', 'Data structures', 'Scientific computing libraries'],
                    'price' => 50000,
                    'status' => 'published',
                    'level' => 'beginner',
                    'user_id' => 1,
                    'duration' => 480, // 8 hours in minutes
                ]),
                Course::create([
                    'title' => 'Data Analysis with Pandas',
                    'slug' => 'data-analysis-with-pandas',
                    'description' => 'Master data manipulation with Python Pandas',
                    'requirements' => ['Python basics', 'Basic data analysis concepts'],
                    'objectives' => ['Data manipulation', 'Statistical analysis', 'Data cleaning techniques'],
                    'price' => 85000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 600, // 10 hours in minutes
                ]),
                Course::create([
                    'title' => 'SQL for Data Analysis',
                    'slug' => 'sql-for-data-analysis',
                    'description' => 'Master database queries for data analysis',
                    'requirements' => ['Basic data concepts', 'No prior SQL required'],
                    'objectives' => ['Write complex SQL queries', 'Data extraction techniques', 'Database fundamentals'],
                    'price' => 75000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 360, // 6 hours in minutes
                ]),
                Course::create([
                    'title' => 'Data Visualization with Python',
                    'slug' => 'data-visualization-python',
                    'description' => 'Create impactful data visualizations',
                    'requirements' => ['Python basics', 'Data analysis knowledge'],
                    'objectives' => ['Create effective visualizations', 'Use Matplotlib and Seaborn', 'Visual storytelling'],
                    'price' => 90000,
                    'status' => 'published',
                    'level' => 'intermediate',
                    'user_id' => 1,
                    'duration' => 420, // 7 hours in minutes
                ]),
                Course::create([
                    'title' => 'Machine Learning Fundamentals',
                    'slug' => 'machine-learning-fundamentals',
                    'description' => 'Introduction to machine learning algorithms',
                    'requirements' => ['Python programming', 'Basic statistics', 'Linear algebra concepts'],
                    'objectives' => ['Supervised learning', 'Unsupervised learning', 'Model evaluation'],
                    'price' => 135000,
                    'status' => 'published',
                    'level' => 'advanced',
                    'user_id' => 1,
                    'duration' => 900, // 15 hours in minutes
                ]),
            ]);
        }
        
        return $courses;
    }

    private function createWebDevelopmentPath($courses)
    {
        // Create Learning Path
        $path = LearningPath::create([
            'title' => 'Menjadi Web Developer Professional',
            'slug' => 'web-developer-professional',
            'description' => 'Jalur pembelajaran komprehensif untuk menjadi web developer profesional. Dimulai dari dasar HTML & CSS hingga pengembangan aplikasi web kompleks menggunakan framework modern.',
            'short_description' => 'Kuasai keterampilan untuk menjadi web developer profesional dari dasar hingga mahir',
            'thumbnail' => 'learning_paths/thumbnails/web-development.jpg',
            'banner_image' => 'learning_paths/banners/web-development-banner.jpg',
            'estimated_hours' => 120,
            'difficulty_level' => 'all-levels',
            'prerequisites' => "- Dasar logika pemrograman\n- Kemampuan dasar menggunakan komputer\n- Koneksi internet yang stabil\n- Keinginan kuat untuk belajar",
            'outcomes' => "- Membangun website responsive dari awal\n- Menguasai HTML, CSS, dan JavaScript\n- Mengembangkan aplikasi web dengan Laravel\n- Mengintegrasikan frontend dan backend\n- Menerapkan praktik keamanan web\n- Mengoptimalkan performa website",
            'status' => 'published',
        ]);

        // Stage 1: Fundamental Web
        $stage1 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Dasar-Dasar Web Development',
            'description' => 'Pelajari fundamental pembangunan website dengan HTML dan CSS',
            'order' => 1,
            'icon' => 'fa-code',
            'badge_image' => 'learning_paths/badges/html-css-badge.png',
        ]);

        // Stage 2: JavaScript & Frontend
        $stage2 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'JavaScript & Frontend Development',
            'description' => 'Kuasai JavaScript dan teknik pengembangan frontend modern',
            'order' => 2,
            'icon' => 'fa-js',
            'badge_image' => 'learning_paths/badges/javascript-badge.png',
        ]);

        // Stage 3: PHP & Backend
        $stage3 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'PHP & Backend Development',
            'description' => 'Pelajari pengembangan backend dengan PHP dan database MySQL',
            'order' => 3,
            'icon' => 'fa-php',
            'badge_image' => 'learning_paths/badges/php-badge.png',
        ]);

        // Stage 4: Laravel Framework
        $stage4 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Laravel Framework',
            'description' => 'Kuasai framework Laravel untuk pengembangan aplikasi web professional',
            'order' => 4,
            'icon' => 'fa-laravel',
            'badge_image' => 'learning_paths/badges/laravel-badge.png',
        ]);

        // Stage 5: Full Stack Development
        $stage5 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Full Stack Development',
            'description' => 'Gabungkan semua keterampilan untuk menjadi full stack developer',
            'order' => 5,
            'icon' => 'fa-layer-group',
            'badge_image' => 'learning_paths/badges/fullstack-badge.png',
        ]);

        // Add courses to stages
        $webCourses = $courses->take(min(8, $courses->count()));
        $coursesPerStage = ceil($webCourses->count() / 5);
        
        // Distribute courses among stages
        for ($i = 0; $i < $webCourses->count(); $i++) {
            $stageId = $i < $coursesPerStage ? $stage1->id : 
                      ($i < $coursesPerStage * 2 ? $stage2->id :
                      ($i < $coursesPerStage * 3 ? $stage3->id :
                      ($i < $coursesPerStage * 4 ? $stage4->id : $stage5->id)));
                      
            PathStageCourse::create([
                'path_stage_id' => $stageId,
                'course_id' => $webCourses[$i]->id,
                'order' => $i % $coursesPerStage + 1,
                'is_required' => true,
            ]);
        }

        // Create achievements
        $this->createPathAchievements($path);
    }

    private function createMobileDevelopmentPath($courses)
    {
        // Create Learning Path
        $path = LearningPath::create([
            'title' => 'Menjadi Mobile App Developer',
            'slug' => 'mobile-app-developer',
            'description' => 'Jalur pembelajaran terstruktur untuk membangun aplikasi mobile profesional. Kuasai pengembangan aplikasi untuk Android, iOS, atau platform cross-platform seperti Flutter dan React Native.',
            'short_description' => 'Kembangkan aplikasi mobile untuk Android dan iOS',
            'thumbnail' => 'learning_paths/thumbnails/mobile-development.jpg',
            'banner_image' => 'learning_paths/banners/mobile-development-banner.jpg',
            'estimated_hours' => 100,
            'difficulty_level' => 'intermediate',
            'prerequisites' => "- Dasar pemrograman (disarankan)\n- Pemahaman tentang UI/UX\n- Komputer dengan spesifikasi memadai\n- Koneksi internet yang stabil",
            'outcomes' => "- Membangun aplikasi Android dengan Kotlin\n- Membuat aplikasi iOS dengan Swift\n- Mengembangkan aplikasi cross-platform dengan Flutter\n- Menerapkan desain UI/UX mobile yang baik\n- Mengintegrasikan API dan database\n- Mempublikasikan aplikasi ke Play Store/App Store",
            'status' => 'published',
        ]);

        // Stage 1: Introduction to Mobile Development
        $stage1 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Pengenalan Mobile Development',
            'description' => 'Pelajari dasar-dasar pengembangan aplikasi mobile',
            'order' => 1,
            'icon' => 'fa-mobile-alt',
            'badge_image' => 'learning_paths/badges/mobile-intro-badge.png',
        ]);

        // Stage 2: Android Development
        $stage2 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Android Development',
            'description' => 'Kuasai pengembangan aplikasi Android dengan Kotlin',
            'order' => 2,
            'icon' => 'fa-android',
            'badge_image' => 'learning_paths/badges/android-badge.png',
        ]);

        // Stage 3: iOS Development
        $stage3 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'iOS Development',
            'description' => 'Pelajari pembuatan aplikasi iOS dengan Swift',
            'order' => 3,
            'icon' => 'fa-apple',
            'badge_image' => 'learning_paths/badges/ios-badge.png',
        ]);

        // Stage 4: Cross-Platform Development
        $stage4 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Cross-Platform Development',
            'description' => 'Kembangkan aplikasi untuk Android dan iOS sekaligus dengan Flutter',
            'order' => 4,
            'icon' => 'fa-mobile',
            'badge_image' => 'learning_paths/badges/flutter-badge.png',
        ]);

        // Add courses to stages
        $mobileCourses = $courses->take(min(7, $courses->count()));
        $coursesPerStage = ceil($mobileCourses->count() / 4);
        
        // Distribute courses among stages
        for ($i = 0; $i < $mobileCourses->count(); $i++) {
            $stageId = $i < $coursesPerStage ? $stage1->id : 
                      ($i < $coursesPerStage * 2 ? $stage2->id :
                      ($i < $coursesPerStage * 3 ? $stage3->id : $stage4->id));
                      
            PathStageCourse::create([
                'path_stage_id' => $stageId,
                'course_id' => $mobileCourses[$i]->id,
                'order' => $i % $coursesPerStage + 1,
                'is_required' => true,
            ]);
        }

        // Create achievements
        $this->createPathAchievements($path);
    }

    private function createDataSciencePath($courses)
    {
        // Create Learning Path
        $path = LearningPath::create([
            'title' => 'Data Science & Analytics',
            'slug' => 'data-science-analytics',
            'description' => 'Jalur pembelajaran untuk menjadi seorang data scientist. Pelajari teknik analisis data, machine learning, dan cara menggunakan tools populer seperti Python, Pandas, dan SQL untuk mengolah data menjadi insight bernilai.',
            'short_description' => 'Kuasai teknik analisis data dan machine learning',
            'thumbnail' => 'learning_paths/thumbnails/data-science.jpg',
            'banner_image' => 'learning_paths/banners/data-science-banner.jpg',
            'estimated_hours' => 150,
            'difficulty_level' => 'beginner',
            'prerequisites' => "- Dasar matematika dan statistika\n- Logika pemrograman\n- Kemauan belajar konsep baru\n- Ketertarikan pada analisis data",
            'outcomes' => "- Menganalisis data dengan Python dan Pandas\n- Memvisualisasikan data secara efektif\n- Membangun model machine learning\n- Menggunakan SQL untuk query database\n- Menginterpretasikan hasil analisis data\n- Menerapkan teknik data science untuk pemecahan masalah",
            'status' => 'published',
        ]);

        // Stage 1: Python Basics
        $stage1 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Python untuk Data Science',
            'description' => 'Pelajari dasar Python untuk analisis data',
            'order' => 1,
            'icon' => 'fa-python',
            'badge_image' => 'learning_paths/badges/python-badge.png',
        ]);

        // Stage 2: Data Analysis
        $stage2 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Data Analysis & SQL',
            'description' => 'Kuasai teknik analisis data dengan Pandas dan SQL',
            'order' => 2,
            'icon' => 'fa-table',
            'badge_image' => 'learning_paths/badges/data-analysis-badge.png',
        ]);

        // Stage 3: Data Visualization
        $stage3 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Data Visualization',
            'description' => 'Pelajari visualisasi data yang efektif dan menarik',
            'order' => 3,
            'icon' => 'fa-chart-bar',
            'badge_image' => 'learning_paths/badges/data-viz-badge.png',
        ]);

        // Stage 4: Machine Learning
        $stage4 = PathStage::create([
            'learning_path_id' => $path->id,
            'title' => 'Machine Learning',
            'description' => 'Kuasai dasar-dasar machine learning dan implementasinya',
            'order' => 4,
            'icon' => 'fa-robot',
            'badge_image' => 'learning_paths/badges/machine-learning-badge.png',
        ]);

        // Add courses to stages
        $dataCourses = $courses->take(min(7, $courses->count()));
        $coursesPerStage = ceil($dataCourses->count() / 4);
        
        // Distribute courses among stages
        for ($i = 0; $i < $dataCourses->count(); $i++) {
            $stageId = $i < $coursesPerStage ? $stage1->id : 
                      ($i < $coursesPerStage * 2 ? $stage2->id :
                      ($i < $coursesPerStage * 3 ? $stage3->id : $stage4->id));
                      
            PathStageCourse::create([
                'path_stage_id' => $stageId,
                'course_id' => $dataCourses[$i]->id,
                'order' => $i % $coursesPerStage + 1,
                'is_required' => true,
            ]);
        }

        // Create achievements
        $this->createPathAchievements($path);
    }

    private function createPathAchievements($path)
    {
        // Completion achievement
        PathAchievement::create([
            'learning_path_id' => $path->id,
            'title' => 'Path Completer',
            'description' => 'Menyelesaikan seluruh jalur pembelajaran ' . $path->title,
            'badge_image' => 'learning_paths/achievements/completion-badge.png',
            'requirement_type' => 'path_completion',
            'requirement_value' => 100,
        ]);

        // 50% Progress achievement
        PathAchievement::create([
            'learning_path_id' => $path->id,
            'title' => 'Halfway Hero',
            'description' => 'Mencapai kemajuan 50% pada jalur pembelajaran ' . $path->title,
            'badge_image' => 'learning_paths/achievements/progress-50-badge.png',
            'requirement_type' => 'progress_milestone',
            'requirement_value' => 50,
        ]);

        // Create stage completion achievements for each stage
        $stages = PathStage::where('learning_path_id', $path->id)->get();
        foreach ($stages as $stage) {
            PathAchievement::create([
                'learning_path_id' => $path->id,
                'title' => $stage->title . ' Master',
                'description' => 'Menyelesaikan tahap ' . $stage->title,
                'badge_image' => 'learning_paths/achievements/stage-badge.png',
                'requirement_type' => 'stage_completion',
                'requirement_value' => $stage->id,
            ]);
        }
    }
}
