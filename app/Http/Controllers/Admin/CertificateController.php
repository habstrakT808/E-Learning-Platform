<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;
use App\Models\LearningPath;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index()
    {
        $certificates = Certificate::with(['user', 'course', 'learningPath'])
            ->latest('issued_at')
            ->paginate(15);
            
        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        $users = User::role('student')->get();
        $courses = Course::where('status', 'published')->get();
        $learningPaths = LearningPath::where('status', 'published')->get();
        
        return view('admin.certificates.create', compact('users', 'courses', 'learningPaths'));
    }

    /**
     * Store a newly created certificate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_type' => 'required|in:course,path',
            'course_id' => 'required_if:certificate_type,course|nullable|exists:courses,id',
            'learning_path_id' => 'required_if:certificate_type,path|nullable|exists:learning_paths,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:50',
            'issued_at' => 'nullable|date',
        ]);
        
        // Generate certificate number
        $certificateNumber = Certificate::generateCertificateNumber();
        
        // Create certificate
        $certificate = Certificate::create([
            'user_id' => $validated['user_id'],
            'course_id' => $validated['certificate_type'] == 'course' ? $validated['course_id'] : null,
            'learning_path_id' => $validated['certificate_type'] == 'path' ? $validated['learning_path_id'] : null,
            'certificate_number' => $certificateNumber,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'template' => $validated['template'] ?? 'default',
            'issued_at' => $validated['issued_at'] ?? now(),
        ]);
        
        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate created successfully.');
    }

    /**
     * Remove a certificate.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        
        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }
} 