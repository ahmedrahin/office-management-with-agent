@extends('backend.layout.template')

@section('page-title')
    <title>Agent Details || {{ \App\Models\Settings::site_title() }}</title>
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
                        <img src="{{ $agent->image ? asset($agent->image) : asset('backend/images/user.jpg') }}" class="student-img" alt="Student Image">
                        <h3 class="mt-3">{{ $agent->name }}</h3>
                        <p class="text-muted">{{ $agent->email ?? 'No Email Provided' }}</p>
                    </div>

                    <div class="card-body pt-0">

                        <!-- ==================== Contact Information ==================== -->
                        <h5 class="text-primary mb-3">Contact Information</h5>
                        <div class="info-group"><strong>Phone:</strong><span>{{ $agent->phone }}</span></div>
                        <div class="info-group"><strong>WhatsApp:</strong><span>{{ $agent->whatsapp ?? 'Not Available' }}</span></div>

                        <!-- ==================== Address Information ==================== -->
                        <h5 class="text-primary mt-4 mb-3">Address Information</h5>
                        <div class="info-group"><strong>Current Address:</strong><span>{{ $agent->current_address ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Permanent Address:</strong><span>{{ $agent->permanent_address ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Division:</strong><span>{{ $agent->division ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>District:</strong><span>{{ $agent->district ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Sub District:</strong><span>{{ $agent->sub_district ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Ward No:</strong><span>{{ $agent->ward_no ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Village:</strong><span>{{ $agent->village ?? 'N/A' }}</span></div>

                        <!-- ==================== Identification Information ==================== -->
                        <h5 class="text-primary mt-4 mb-3">Identification Information</h5>
                        <div class="info-group"><strong>NID Number:</strong><span>{{ $agent->nid_number ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Passport Number:</strong><span>{{ $agent->passport_number ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Assign Date:</strong><span>{{ $agent->created_at->format('d M Y') }}</span></div>

                        <!-- ==================== Family Information ==================== -->
                        <h5 class="text-primary mt-4 mb-3">Family Information</h5>
                        <div class="info-group"><strong>Father's Name:</strong><span>{{ $agent->father_name ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Mother's Name:</strong><span>{{ $agent->mother_name ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Wife's Name:</strong><span>{{ $agent->wife_name ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Spouse's Name:</strong><span>{{ $agent->spouse_name ?? 'N/A' }}</span></div>

                        <!-- ==================== Education & Experience ==================== -->
                        <h5 class="text-primary mt-4 mb-3">Education & Experience</h5>
                        <div class="info-group"><strong>Educational Qualification:</strong><span>{{ $agent->education_qualification ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Study Institute:</strong><span>{!! $agent->study_institute ?? 'N/A' !!}</span></div>
                        <div class="info-group"><strong>Previous Experience:</strong><span>{!! $agent->previous_experience ?? 'N/A' !!}</span></div>
                        <div class="info-group"><strong>Experience Years:</strong><span>{{ $agent->experience_years ?? 'N/A' }}</span></div>
                        <div class="info-group"><strong>Institute Name:</strong><span>{!! $agent->institute_name ?? 'N/A' !!}</span></div>

                        <!-- ==================== Visitor Statistics ==================== -->
                        <h5 class="text-primary mt-4 mb-3">Visitor Statistics</h5>
                        <div class="info-group"><strong>Total Students Added:</strong><span>{{ $agent->student->count() }}</span></div>
                        <div class="info-group"><strong>Total Job Inquiry Persons Added:</strong><span>{{ $agent->person->count() }}</span></div>
                        <div class="info-group"><strong>Total Tourists Added:</strong><span>{{ $agent->tourist->count() }}</span></div>


                    </div>

                     <!-- course List -->
                    <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Added Student List</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th class="text-center">Register Date</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Registation::where('agent_id', $agent->id)->latest()->get() as $index => $data)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td >{{ $data->name }}</td>
                                                    <td class="text-center">{{ $data->created_at->format('d M Y') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('student-registration.show',$data->id) }}">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($agent->student->isEmpty())
                                        <p class="text-center text-danger mt-3">No student added yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Added Job Inquiry</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Person Name</th>
                                                <th class="text-center">Register Date</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\JobInquiry::where('agent_id', $agent->id)->latest()->get() as $index => $data)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td >{{ $data->name }}</td>
                                                    <td class="text-center">{{ $data->created_at->format('d M Y') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('inquiry.show',$data->id) }}">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($agent->person->isEmpty())
                                        <p class="text-center text-danger mt-3">No person added yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Added Tourist List</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Tourist Name</th>
                                                <th class="text-center">Register Date</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Tourist::where('agent_id', $agent->id)->latest()->get() as $index => $data)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td >{{ $data->name }}</td>
                                                    <td class="text-center">{{ $data->created_at->format('d M Y') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('tour-travel.show',$data->id) }}">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($agent->tourist->isEmpty())
                                        <p class="text-center text-danger mt-3">No tourist added yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ route('agent.edit', $agent->id) }}" class="btn btn-warning">Edit</a>
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
