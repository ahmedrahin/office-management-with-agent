@extends('backend.layout.template')

@section('page-title')
    <title>Country Details || {{ \App\Models\Settings::site_title() }}</title>
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
                        <h3 class="mt-3">{{ $data->name }}</h3>
                    </div>

                    <div class="card-body pt-0">
                        <div class="info-group"><strong>Total visitors in this country:</strong><span>{{ $data->student->count() + $data->person->count() + $data->tourist->count() }}</span></div>
                        <div class="info-group"><strong>Total student assign in this country:</strong><span>{{ $data->student->count() }}</span></div>
                        <div class="info-group"><strong>Total job inquiry person assign in this country:</strong><span>{{ $data->person->count() }}</span></div>
                        <div class="info-group"><strong>Total tourist assign in this country:</strong><span>{{ $data->tourist->count() }}</span></div>
                        <div class="info-group"><strong>Total university in this country:</strong><span>{{ $data->university->count() }}</span></div>
                        <div class="info-group"><strong>Total job/company in this country:</strong><span>{{ $data->jobTypes->count() }}</span></div>
                        <div class="info-group"><strong>Total tourist places in this country:</strong><span>{{ $data->touristPlaces->count() }}</span></div>
                    </div>

                   <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Assign Student List</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th class="text-center">Total Cost</th>
                                                <th class="text-center">Phone no.</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    @if($data->student->isEmpty())
                                        <p class="text-center mt-3 text-danger">No student assign.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-1">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Assign Tourist List</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th class="text-center">Total Cost</th>
                                                <th class="text-center">Phone no.</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    @if($data->student->isEmpty())
                                        <p class="text-center mt-3 text-danger">No tourist assign.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ route('country.edit', $data->id) }}" class="btn btn-warning">Edit</a>
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
