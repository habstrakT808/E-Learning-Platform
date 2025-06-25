<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'learning_path_id',
        'certificate_number',
        'title',
        'description',
        'template',
        'metadata',
        'pdf_path',
        'image_path',
        'issued_at',
        'expires_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user who owns the certificate
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course associated with the certificate
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the learning path associated with the certificate
     */
    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class);
    }

    /**
     * Get the certificate image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        
        return Storage::url($this->image_path);
    }

    /**
     * Get the certificate PDF URL
     */
    public function getPdfUrlAttribute()
    {
        if (!$this->pdf_path) {
            return null;
        }
        
        return Storage::url($this->pdf_path);
    }

    /**
     * Get the URL for the certificate preview image
     */
    public function getPreviewImageUrlAttribute()
    {
        // If there's a custom image set, return that
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        // For course certificates
        if ($this->course_id) {
            $courseTitle = $this->course->title ?? '';
            
            // Match course titles to specific certificate designs
            if (stripos($courseTitle, 'python') !== false || stripos($courseTitle, 'data science') !== false) {
                return asset('images/certificates/previews/course-certificate-python.svg');
            } elseif (stripos($courseTitle, 'ui') !== false || stripos($courseTitle, 'ux') !== false || stripos($courseTitle, 'design principles') !== false) {
                return asset('images/certificates/previews/course-certificate-uiux.svg');
            } elseif (stripos($courseTitle, 'graphic') !== false) {
                return asset('images/certificates/previews/course-certificate-graphic.svg');
            } else {
                // Default course certificate
                return asset('images/certificates/previews/course-certificate-python.svg');
            }
        }
        
        // For learning path certificates
        if ($this->learning_path_id) {
            $pathTitle = $this->learningPath->title ?? '';
            
            // Match path titles to specific certificate designs
            if (stripos($pathTitle, 'web') !== false || stripos($pathTitle, 'developer') !== false) {
                return asset('images/certificates/previews/path-certificate-web.svg');
            } elseif (stripos($pathTitle, 'mobile') !== false || stripos($pathTitle, 'app') !== false) {
                return asset('images/certificates/previews/path-certificate-mobile.svg');
            } elseif (stripos($pathTitle, 'data') !== false || stripos($pathTitle, 'analytics') !== false) {
                return asset('images/certificates/previews/path-certificate-datascience.svg');
            } else {
                // Default path certificate
                return asset('images/certificates/previews/path-certificate-web.svg');
            }
        }
        
        // Fallback default
        return asset('images/certificates/previews/course-certificate-python.svg');
    }

    /**
     * Generate a unique certificate number
     */
    public static function generateCertificateNumber()
    {
        $prefix = 'CERT';
        $year = date('Y');
        $random = strtoupper(substr(md5(microtime()), 0, 6));
        
        $number = "{$prefix}-{$year}-{$random}";
        
        // Make sure it's unique
        while (self::where('certificate_number', $number)->exists()) {
            $random = strtoupper(substr(md5(microtime()), 0, 6));
            $number = "{$prefix}-{$year}-{$random}";
        }
        
        return $number;
    }

    /**
     * Create a certificate for course completion
     */
    public static function createForCourse($userId, $courseId)
    {
        $user = User::findOrFail($userId);
        $course = Course::findOrFail($courseId);
        
        // Check if certificate already exists
        $existing = self::where('user_id', $userId)
                        ->where('course_id', $courseId)
                        ->first();
        
        if ($existing) {
            return $existing;
        }
        
        $certificate = self::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'certificate_number' => self::generateCertificateNumber(),
            'title' => "Course Completion: {$course->title}",
            'description' => "This is to certify that {$user->name} has successfully completed the course {$course->title}.",
            'template' => 'course',
            'issued_at' => now(),
        ]);
        
        // Generate and store certificate files
        // This would be implemented based on the certificate generation approach
        
        return $certificate;
    }
    
    /**
     * Create a certificate for learning path completion
     */
    public static function createForPath($userId, $pathId)
    {
        $user = User::findOrFail($userId);
        $path = LearningPath::findOrFail($pathId);
        
        // Check if certificate already exists
        $existing = self::where('user_id', $userId)
                        ->where('learning_path_id', $pathId)
                        ->first();
        
        if ($existing) {
            return $existing;
        }
        
        $certificate = self::create([
            'user_id' => $userId,
            'learning_path_id' => $pathId,
            'certificate_number' => self::generateCertificateNumber(),
            'title' => "Path Completion: {$path->title}",
            'description' => "This is to certify that {$user->name} has successfully completed the learning path {$path->title}.",
            'template' => 'path',
            'issued_at' => now(),
        ]);
        
        // Generate and store certificate files
        // This would be implemented based on the certificate generation approach
        
        return $certificate;
    }
} 