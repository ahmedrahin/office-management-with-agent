@extends('backend.layout.template')

@section('page-title')
    <title>Person Details || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
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
        .image-gallery {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            /* margin-top: 20px; */
            margin-bottom: 30px;
        }
        .image-gallery a img {
            width: 160px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ddd;
            transition: transform 0.3s;
        }
        .image-gallery a img:hover {
            transform: scale(1.05);
            border-color: #007bff;
        }
    </style>
@endsection

@section('body-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card student-card mb-4">
                    <div class="card-body text-center pb-0">
                        <img src="{{ $student->image ? asset($student->image) : asset('backend/images/user.jpg') }}" class="student-img" alt="Student Image">
                        <h3 class="mt-3">{{ $student->name }}</h3>
                        <p class="text-muted">{{ $student->email ?? 'No Email Provided' }}</p>
                    </div>

                    <div class="card-body pt-0">
                        {{-- Info Groups --}}
                        <div class="info-group"><strong>Father's Name:</strong><span>{{ $student->father_name }}</span></div>
                        <div class="info-group"><strong>Mother's Name:</strong><span>{{ $student->mother_name }}</span></div>
                        <div class="info-group"><strong>Gender:</strong><span>{{ ucfirst($student->gender) }}</span></div>
                        <div class="info-group"><strong>Date of Birth:</strong><span>{{ $student->date_of_birth }}</span></div>
                        <div class="info-group"><strong>Mobile:</strong><span>{{ $student->mobile }}</span></div>
                        <div class="info-group"><strong>Permanent Address:</strong><span>{{ $student->permanent_address }}, {{ $student->permanent_district }}, {{ $student->permanent_division }}</span></div>
                        <div class="info-group"><strong>Temporary Address:</strong><span>{{ $student->temporary_address }}, {{ $student->temporary_district }}, {{ $student->temporary_division }}</span></div>
                        <div class="info-group"><strong>Country:</strong><span><a href="{{ route('country.show', $student->country->id) }}" target="_blank">{{ $student->country->name }}</a></span></div>
                        <div class="info-group"><strong>Job Type:</strong><span><a href="{{ route('job.show', $student->jobType->id) }}" target="_blank">{{ $student->jobType->name }}</a></span></div>
                        
                        <div class="info-group"><strong>Total_cost:</strong><span>{{ $student->total_cost }}BDT</span></div>
                        {{-- <div class="info-group"><strong>Processing Fees:</strong><span>{{ $student->processing_fees > 0 ? $student->processing_fees . ' BDT' : 'N/A' }}</span></div> --}}
                        <div class="info-group"><strong>Added by:</strong><span>{{ $student->user_id ? optional($student->user)->name . ' - (admin)' : optional($student->agent)->name . ' - (agent)' }}</span></div>
                        <div class="info-group"><strong>Register Date:</strong><span>{{ $student->created_at->format('d M Y') }}</span></div>
                    </div>

                    {{-- 🖼️ Student Documents --}}
                    <div class="image-gallery">
                        @if($student->image)
                            <a href="{{ asset($student->image) }}" data-lightbox="student-gallery" data-title="Profile Image">
                                <img src="{{ asset($student->image) }}" alt="Profile Image">
                            </a>
                        @endif

                        @if($student->front_image)
                            <a href="{{ asset($student->front_image) }}" data-lightbox="student-gallery" data-title="Front Image">
                                <img src="{{ asset($student->front_image) }}" alt="Front Image">
                            </a>
                        @endif

                        @if($student->back_image)
                            <a href="{{ asset($student->back_image) }}" data-lightbox="student-gallery" data-title="Back Image">
                                <img src="{{ asset($student->back_image) }}" alt="Back Image">
                            </a>
                        @endif

                        @if($student->passport_image)
                            <a href="{{ asset($student->passport_image) }}" data-lightbox="student-gallery" data-title="Passport Image">
                                <img src="{{ asset($student->passport_image) }}" alt="Passport Image">
                            </a>
                        @endif
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ route('student-registration.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                        <button onclick="window.print()" class="btn btn-success ms-2">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
@endsection
