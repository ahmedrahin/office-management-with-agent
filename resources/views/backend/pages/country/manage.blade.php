@extends('backend.layout.template')
@section('page-title')
    <title>All Agent List || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
@endsection

@section('body-content')

    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">All Agent List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title" style="display: flex;justify-content: space-between;align-items:center;">
                                <div>
                                    All Agent List
                                </div>
                                <div>
                                    <a href="{{ route('agent.create') }}" class="btn btn-primary">Add New</a>
                                </div>
                            </h4>
                            <div class="data">
                                @if( $data->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th class="text-center">Image</th>
                                                <th>Name</th>
                                                <th>Created_at</th>
                                                <th>Created_by</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; // Initialize counter variable
                                            @endphp
                                            @foreach ($data as $v)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$v->name}}</td>
                                                    
                                                    <td>{{ \Carbon\Carbon::parse($v->created_at)->format('d M, Y') }}</td>
                                                    <td>{{ optional($v->user)->name ?? 'N/A' }}</td>
                                                    <td>

                                                    </td>
                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('country.edit',$v->id)}}">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        </button>
                                                        <button class="deleteButton" data-id="{{ $v->id }}">
                                                            <i class="ri-delete-bin-2-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            
        </div> 
    </div>
    <!-- End Page-content -->
                
@endsection

@section('page-script')
   
    
    <!-- Responsive examples -->
    <script src="{{asset('backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{asset('backend/js/pages/datatables.init.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{asset('backend/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('backend/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

    <script src="{{asset('backend/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>


@endsection