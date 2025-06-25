<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all enrollments with course details
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with(['course', 'course.instructor'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get all payments
        $payments = Payment::where('user_id', $user->id)
            ->with(['enrollment.course'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('student.payments.index', compact('enrollments', 'payments'));
    }
    
    public function showInvoice($paymentId)
    {
        $payment = Payment::where('user_id', Auth::id())
            ->with(['enrollment.course', 'enrollment.course.instructor'])
            ->findOrFail($paymentId);
            
        return view('student.payments.invoice', compact('payment'));
    }
    
    public function downloadInvoice($paymentId)
    {
        $payment = Payment::where('user_id', Auth::id())
            ->with(['enrollment.course', 'enrollment.course.instructor'])
            ->findOrFail($paymentId);
            
        // Generate PDF invoice
        $pdf = \PDF::loadView('student.payments.invoice-pdf', compact('payment'));
        
        return $pdf->download('invoice-' . $payment->invoice_number . '.pdf');
    }
} 