@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow">
        <!-- Invoice Header -->
        <div class="p-8 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Invoice</h1>
                    <p class="text-gray-600">Invoice #{{ $payment->invoice_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Date: {{ $payment->payment_date->format('M d, Y') }}</p>
                    <p class="text-gray-600">Status: 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="p-8 border-b">
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Bill To</h3>
                    <p class="text-gray-600">{{ Auth::user()->name }}</p>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Course Details</h3>
                    <p class="text-gray-600">{{ $payment->enrollment->course->title }}</p>
                    <p class="text-gray-600">Instructor: {{ $payment->enrollment->course->instructor->name }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="p-8 border-b">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment Details</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Course Enrollment: {{ $payment->enrollment->course->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Total
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="p-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment Method</h3>
            <p class="text-gray-600">Method: {{ ucfirst($payment->payment_method) }}</p>
            <p class="text-gray-600">Transaction ID: {{ $payment->transaction_id }}</p>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('student.payments.download-invoice', $payment->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Download Invoice
                </a>
                <a href="{{ route('student.payments') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Back to Payments
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 