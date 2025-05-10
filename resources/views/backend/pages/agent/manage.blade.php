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
                                    <a href="{{ route('agent.create') }}" class="btn btn-primary addnew"><i class="ri-add-line"></i> Add New</a>
                                </div>
                            </h4>
                            <div class="data table-responsive">
                                @if( $employees->count() == 0 )
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
                                                <th>Email</th>
                                                <th>Phone No.</th>
                                                <th class="text-center">Total Added</th>
                                                <th class="text-center">Students</th>
                                                <th class="text-center">Job Inquiry</th>
                                                <th class="text-center">Tourist</th>
                                                <th>Created_at</th>
                                                <th style="text-align: center;">Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; // Initialize counter variable
                                            @endphp
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td class="text-center">
                                                        @if( !is_null($employee->image) )
                                                            <img src="{{asset($employee->image)}}" alt="" class="user-img">
                                                        @else
                                                            <img src="{{asset('backend/images/user.jpg')}}" alt="" class="user-img">
                                                        @endif
                                                    </td>
                                                    <td>{{$employee->name}}</td>
                                                    
                                                    <td>{{$employee->email}}</td>
                                                    <td>{{$employee->phone}}</td>

                                                    <td align="middle">
                                                        @php
                                                            $data =  $employee->student->count() + $employee->person->count() + $employee->tourist->count() ;
                                                        @endphp
                                                        @if( $data > 0 )
                                                            <span class="badge bg-success">{{ $data }}</span>
                                                        @else
                                                            <span class="badge bg-danger">0</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if( $employee->student->count() > 0 )
                                                            <span class="badge bg-success">{{ $employee->student->count() }}</span>
                                                        @else
                                                            <span class="badge bg-danger">0</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if( $employee->person->count() > 0 )
                                                            <span class="badge bg-success">{{ $employee->person->count() }}</span>
                                                        @else
                                                            <span class="badge bg-danger">0</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if( $employee->tourist->count() > 0 )
                                                            <span class="badge bg-success">{{ $employee->tourist->count() }}</span>
                                                        @else
                                                            <span class="badge bg-danger">0</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d M, Y') }}</td>
                                                    <td align="middle">
                                                        @php
                                                            $switchId = 'switch' . $counter;
                                                        @endphp
                                                        @if($employee->status == 0)
                                                            <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $employee->id }}" switch="success" />
                                                            <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                        @else
                                                            <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $employee->id }}" switch="success" checked />
                                                            <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                        @endif
                                                    </td>
                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('agent.show',$employee->id)}}" target="_blank">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                        <button>
                                                            <a href="{{route('agent.edit',$employee->id)}}">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        </button>
                                                        <button class="deleteButton" data-employee-id="{{ $employee->id }}" style="opacity: .5" >
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
    
    <script>
        $(document).ready(function() {
            $('.status-toggle').change(function() {
                var id = $(this).data('user-id');
                var status = $(this).prop('checked') ? 1 : 0;

                // Send AJAX request
                $.ajax({
                    type: 'PUT',
                    url: '/admin/agent-status/' + id, 
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        // Handle success response here
                        console.log(response);
                        Swal.fire({
                            icon: response.type,
                            title: response.msg,
                            text: ''
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    
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