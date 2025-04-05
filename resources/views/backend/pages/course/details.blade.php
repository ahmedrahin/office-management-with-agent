@extends('backend.layout.template')

@section('page-title')
    <title>Course Details | {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            .page-content {
                margin: 0;
                padding: 0;
                font-size: 14px;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            .card-body {
                padding: 10px;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }
            .btn {
                display: none; 
            }
            .card-header {
                background-color: #007bff;
                color: white;
            }
            h3, h5 {
                color: black;
            }
            .text-success {
                color: green !important;
            }
            .text-danger {
                color: red !important;
            }
        }
    </style>
@endsection

@section('body-content')

<div class="page-content">
    <div class="container">
        <!-- Page Title -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-title-box text-center">
                    <h3 class="fw-bold text-primary">{{ $course->name }} - Details</h3>
                    <p class="text-muted" style="font-size: 16px;font-weight:600;">Manage students, payments, and progress.</p>
                </div>
            </div>
        </div>

        <!-- Course Information (Name, Fees, Timing, Creator) -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-dark d-flex" style="justify-content: space-between;align-items:center;">
                            <div> {{ $course->name }} Course Information</div>
                            <div >
                                <button onclick="window.print()" class="btn btn-success btn-md">
                                    <i class="fa fa-print"></i> Print
                                </button>
                            </div>
                        </h5>
                        <hr>
                        <p><strong>Course Name:</strong> {{ $course->name }}</p>
                        <p><strong>Fees:</strong> ৳{{ number_format($course->fees, 2) }}</p>
                        <p><strong>Start Time:</strong> {{ $course->start_time ?? 'N/A' }}</p>
                        <p><strong>End Time:</strong> {{ $course->end_time ?? 'N/A' }}</p>
                        <p><strong>Created By:</strong> {{ optional($course->user)->name ?? 'Unknown' }}</p>
                        <p><strong>Created At:</strong> {{ $course->created_at ? $course->created_at->format('d, M, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Summary (3 Cards) -->
        <div class="row justify-content-center mt-0">
            <div class="col-md-3">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Enrolled Students</h6>
                        <h4 class="fw-bold text-primary">{{ $totalStudents }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Earnings</h6>
                        <h4 class="fw-bold text-success">৳{{ number_format($totalEarnings, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Due</h6>
                        <h4 class="fw-bold text-danger">৳{{ number_format($totalDue, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Students List -->
        <div class="row justify-content-center mt-1">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white">Enrolled Students List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th class="text-center">Paid</th>
                                    <th class="text-center">Due</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->assign as $key => $assignment)
                                    @php
                                        $paid = $assignment->payment->sum('payment');
                                        $lastPayment = $assignment->payment->last(); 
                                        $due = $lastPayment ? $lastPayment->due_payment : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $assignment->registation->name ?? 'N/A' }}</td>
                                        <td class="text-success fw-bold text-center">৳{{ number_format($paid, 2) }}</td>
                                        <td class="fw-bold text-center" style="{{ $due <= 0 ? 'background-color: #00800080; color: white;' : 'color: red;' }}">
                                            ৳{{ number_format($due, 2) }}
                                        </td>
                                        
                                        <td class="text-center">
                                            @if( isset($assignment->registation) )
                                                <a href="{{ route('student-registration.show',$assignment->registation->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                            @endif
                                            <a href="{{ route('payment',$assignment->id) }}" class="btn btn-sm btn-success">Payment</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($course->assign->isEmpty())
                            <p class="text-center text-muted mt-3">No students assigned to this course.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
