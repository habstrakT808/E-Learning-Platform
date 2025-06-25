<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\PathAchievement;
use App\Models\UserPathAchievement;
use App\Models\Course;
use App\Models\LearningPath;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AchievementController extends Controller
{
    /**
     * Display the user's achievements and certificates
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's certificates
        $certificates = Certificate::where('user_id', $user->id)
            ->with(['course', 'learningPath'])
            ->latest('issued_at')
            ->get();
            
        // Get user's achievements
        $achievements = UserPathAchievement::where('user_id', $user->id)
            ->with(['achievement', 'achievement.learningPath'])
            ->latest('earned_at')
            ->get();
        
        // Group by type
        $courseCertificates = $certificates->where('course_id', '!=', null);
        $pathCertificates = $certificates->where('learning_path_id', '!=', null);
            
        return view('achievements.index', compact(
            'courseCertificates', 
            'pathCertificates', 
            'achievements'
        ));
    }
    
    /**
     * Show a specific certificate
     */
    public function showCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        // Authorization check
        $this->authorize('view', $certificate);
        
        return view('achievements.certificate', compact('certificate'));
    }
    
    /**
     * Download a certificate as PDF
     */
    public function downloadCertificate($id)
    {
        $certificate = Certificate::with(['user', 'course', 'learningPath'])->findOrFail($id);
        
        // Authorization check
        $this->authorize('view', $certificate);
        
        // If PDF already exists
        if ($certificate->pdf_path && Storage::exists($certificate->pdf_path)) {
            return Storage::download(
                $certificate->pdf_path, 
                'Certificate-' . $certificate->certificate_number . '.pdf',
                ['Content-Type' => 'application/pdf']
            );
        }
        
        // Generate PDF
        $pdf = PDF::loadView('certificates.pdf', [
            'certificate' => $certificate,
        ]);
        
        // Save to storage (optional)
        $pdfPath = 'certificates/' . $certificate->certificate_number . '.pdf';
        Storage::put($pdfPath, $pdf->output());
        
        // Update certificate record
        $certificate->update(['pdf_path' => $pdfPath]);
        
        return $pdf->download('Certificate-' . $certificate->certificate_number . '.pdf');
    }
    
    /**
     * Share certificate to social media
     */
    public function shareOptions($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        // Authorization check
        $this->authorize('view', $certificate);
        
        // Generate share links
        $shareLinks = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . route('certificates.public', $certificate->certificate_number),
            'twitter' => 'https://twitter.com/intent/tweet?url=' . route('certificates.public', $certificate->certificate_number) . '&text=' . urlencode('I just earned a certificate for ' . $certificate->title),
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . route('certificates.public', $certificate->certificate_number),
        ];
        
        return view('achievements.share', compact('certificate', 'shareLinks'));
    }
    
    /**
     * Public certificate verification page
     */
    public function publicCertificate($certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->with(['user', 'course', 'learningPath'])
            ->firstOrFail();
            
        return view('achievements.public', compact('certificate'));
    }
    
    /**
     * Show all user achievements
     */
    public function showAchievements()
    {
        $user = Auth::user();
        
        // Get user's achievements
        $earnedAchievements = UserPathAchievement::where('user_id', $user->id)
            ->with(['achievement', 'achievement.learningPath'])
            ->latest('earned_at')
            ->get();
            
        // Get all achievements
        $allPathAchievements = PathAchievement::with('learningPath')->get();
        
        // Get earned achievement IDs for comparison
        $earnedIds = $earnedAchievements->pluck('path_achievement_id')->toArray();
        
        // Filter uneearned achievements
        $unearnedAchievements = $allPathAchievements->filter(function($achievement) use ($earnedIds) {
            return !in_array($achievement->id, $earnedIds);
        });
        
        return view('achievements.badges', compact('earnedAchievements', 'unearnedAchievements'));
    }
} 