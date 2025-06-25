<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik platform
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::role('student')->count(),
            'total_instructors' => User::role('instructor')->count(),
            'total_courses' => Course::count(),
            'published_courses' => Course::where('status', 'published')->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Enrollment::sum('amount_paid'),
            'avg_course_rating' => round(Review::avg('rating') ?? 0, 1),
        ];
        
        // Grafik pertumbuhan pendaftaran (12 bulan terakhir)
        $lastYear = Carbon::now()->subMonths(11);
        $enrollmentData = $this->getMonthlyData(
            Enrollment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->where('created_at', '>=', $lastYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
        );

        // Pendapatan bulanan (12 bulan terakhir)
        $revenueData = $this->getMonthlyData(
            Enrollment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount_paid) as total')
                ->where('created_at', '>=', $lastYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'total'
        );

        // Pendaftaran baru berdasarkan kategori kursus (30 hari terakhir)
        $categoriesData = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('course_categories', 'courses.id', '=', 'course_categories.course_id')
            ->join('categories', 'course_categories.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(enrollments.id) as count')
            ->where('enrollments.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('categories.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // User baru (30 hari terakhir)
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))
            ->latest()
            ->limit(10)
            ->get();

        // Enrollments baru (30 hari terakhir)
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->latest()
            ->limit(10)
            ->get();

        // Kursus paling populer
        $popularCourses = Course::withCount(['enrollments'])
            ->with(['instructor'])
            ->orderByDesc('enrollments_count')
            ->limit(5)
            ->get();

        // Status sistem
        $systemStatus = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'memory_usage' => $this->formatBytes(memory_get_usage(true)),
            'database_size' => $this->getDatabaseSize(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'enrollmentData',
            'revenueData',
            'categoriesData',
            'newUsers',
            'recentEnrollments',
            'popularCourses',
            'systemStatus'
        ));
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get database size from MySQL information schema
     */
    private function getDatabaseSize()
    {
        try {
            $result = DB::select('SELECT SUM(data_length + index_length) as size FROM information_schema.tables WHERE table_schema = ?', [env('DB_DATABASE')]);
            return $this->formatBytes($result[0]->size);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Format monthly data to ensure all months are included
     */
    private function getMonthlyData($data, $valueField = 'count')
    {
        $result = [];
        $period = CarbonPeriod::create(Carbon::now()->subMonths(11)->startOfMonth(), '1 month', Carbon::now()->endOfMonth());
        $months = collect($period)->map(fn ($date) => $date->format('Y-m'));
        
        // Initialize all months with zero
        foreach ($months as $month) {
            $result[$month] = 0;
        }
        
        // Fill in data that exists
        foreach ($data as $item) {
            if (isset($result[$item->month])) {
                $result[$item->month] = (float)$item->$valueField;
            }
        }
        
        return [
            'labels' => array_map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->format('M Y'), array_keys($result)),
            'values' => array_values($result)
        ];
    }
}
