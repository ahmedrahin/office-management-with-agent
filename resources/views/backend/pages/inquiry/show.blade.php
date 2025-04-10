@extends('backend.layout.template')

@section('page-title')
    <title>Student Details || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        .student-card {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .student-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
        }
        .info-group {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
    </style>
@endsection

@section('body-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card student-card">
                    <div class="card-body text-center">
                        <img src="{{ $student->image ? asset($student->image) : asset('backend/images/user.jpg') }}" class="student-img" alt="Student Image">
                        <h3 class="mt-3">{{ $student->name }}</h3>
                        <p class="text-muted">{{ $student->email ?? 'No Email Provided' }}</p>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <strong>Father's Name:</strong>
                            <span>{{ $student->father_name }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Mother's Name:</strong>
                            <span>{{ $student->mother_name }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Gender:</strong>
                            <span>{{ ucfirst($student->gender) }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Date of Birth:</strong>
                            <span>{{ $student->date_of_birth }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Mobile:</strong>
                            <span>{{ $student->mobile }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Assigned Courses:</strong>
                            <div>
                                @if( $student->assign->count() > 0 )
                                    @foreach($student->assign as $assign)
                                        <span class="badge bg-primary">{{ $assign->course->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-danger">no assign yet</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-group">
                            <strong>Permanent Address:</strong>
                            <span>{{ $student->permanent_address }}, {{ $student->permanent_district }}, {{ $student->permanent_division }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Temporary Address:</strong>
                            <span>{{ $student->temporary_address }}, {{ $student->temporary_district }}, {{ $student->temporary_division }}</span>
                        </div>
                        <div class="info-group">
                            <strong>Added by:</strong>
                            <span>{{ optional($student->user)->name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="info-group">
                            <strong>Register Date:</strong>
                            <span>{{ $student->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- course information --}}
                    <div class="row justify-content-center g-2 mt-0">
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3 border-primary">
                                <div class="card-body text-center" style="background: #EFF3F6;">
                                    <h6 class="text-muted">Total Enrolled Course</h6>
                                    <h5 class="fw-bold text-primary">{{ $totalCourse }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3 border-success">
                                <div class="card-body text-center" style="background: #eff3f6b9;">
                                    <h6 class="text-muted">Total Payment</h6>
                                    <h5 class="fw-bold text-success">৳{{number_format($totalPaid,2)}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3 border-danger" style="background: #eff3f6b9;">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">Total Due</h6>
                                    <h5 class="fw-bold text-danger">৳{{number_format($totalDue, 2)}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- course List -->
                    <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Enrolled Course List</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Course Name</th>
                                                <th class="text-center">Paid</th>
                                                <th class="text-center">Due</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->assign as $key => $assignment)
                                                @php
                                                    $paid = $assignment->payment->sum('payment');
                                                    $lastPayment = $assignment->payment->last(); 
                                                    $due = $lastPayment ? $lastPayment->due_payment : 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $assignment->course->name ?? 'N/A' }}</td>
                                                    <td class="text-success fw-bold text-center">৳{{ number_format($paid, 2) }}</td>
                                                    <td class="fw-bold text-center" style="{{ $due <= 0 ? 'background-color: #00800080; color: white;' : 'color: red;' }}">
                                                        ৳{{ number_format($due, 2) }}
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        @if( isset($assignment->registation) )
                                                            <a href="{{ route('course.show',$assignment->course->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                                        @endif
                                                        <a href="{{ route('payment',$assignment->id) }}" class="btn btn-sm btn-success">Payment</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($student->assign->isEmpty())
                                        <p class="text-center text-muted mt-3">No course enrolled for this student.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer text-center">
                        <a href="{{ route('student-registration.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                        <button onclick="window.print()" class="btn btn-success" style="margin-left: 3px;">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
