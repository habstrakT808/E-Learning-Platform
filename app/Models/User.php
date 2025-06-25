<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'phone',
        'date_of_birth',
        'address',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    // Activity Log Configuration
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function publishedCourses()
    {
        return $this->hasMany(Course::class)->where('status', 'published');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('progress', 'enrolled_at', 'completed_at', 'amount_paid')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    // Learning Path relationships
    public function pathEnrollments()
    {
        return $this->hasMany(UserPathEnrollment::class);
    }

    public function enrolledPaths()
    {
        return $this->belongsToMany(LearningPath::class, 'user_path_enrollments')
                    ->withPivot('progress', 'started_at', 'completed_at', 'last_activity_at')
                    ->withTimestamps();
    }

    public function pathAchievements()
    {
        return $this->belongsToMany(PathAchievement::class, 'user_path_achievements')
                    ->withPivot('earned_at', 'metadata')
                    ->withTimestamps();
    }

    // Certificate relationships
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function courseCertificates()
    {
        return $this->hasMany(Certificate::class)->whereNotNull('course_id');
    }

    public function pathCertificates()
    {
        return $this->hasMany(Certificate::class)->whereNotNull('learning_path_id');
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }

    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    // Helper methods for roles
    public function isInstructor()
    {
        return $this->hasRole('instructor');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Course related methods
    public function hasEnrolled($courseId)
    {
        return $this->enrollments()->where('course_id', $courseId)->exists();
    }

    public function getEnrollment($courseId)
    {
        return $this->enrollments()->where('course_id', $courseId)->first();
    }

    public function enrollInCourse($courseId, $amountPaid = 0, $paymentMethod = null)
    {
        return $this->enrollments()->create([
            'course_id' => $courseId,
            'enrolled_at' => now(),
            'amount_paid' => $amountPaid,
            'payment_method' => $paymentMethod,
        ]);
    }

    // Statistics for instructors
    public function getTotalStudentsAttribute()
    {
        return Enrollment::whereIn('course_id', $this->courses->pluck('id'))->count();
    }

    public function getTotalRevenueAttribute()
    {
        return Enrollment::whereIn('course_id', $this->courses->pluck('id'))->sum('amount_paid');
    }

    public function getAverageRatingAttribute()
    {
        $courseIds = $this->courses->pluck('id');
        return Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0;
    }

    // Statistics for students
    public function getCompletedCoursesCountAttribute()
    {
        return $this->enrollments()->whereNotNull('completed_at')->count();
    }

    public function getInProgressCoursesCountAttribute()
    {
        return $this->enrollments()
                    ->whereNull('completed_at')
                    ->where('progress', '>', 0)
                    ->count();
    }

    public function getTotalLearningTimeAttribute()
    {
        return $this->lessonProgress()->sum('watch_time');
    }

    public function getFormattedLearningTimeAttribute()
    {
        $totalSeconds = $this->total_learning_time;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    /**
     * Get discussions created by the user
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get discussion replies by the user
     */
    public function discussionReplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    /**
     * Get votes cast by the user
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get all submissions by this user
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get bookmarks created by the user
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get bookmark categories created by the user
     */
    public function bookmarkCategories()
    {
        return $this->hasMany(BookmarkCategory::class);
    }
}