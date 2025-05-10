@extends('backend.layout.template')
@section('page-title')
    <title>Manage Products  || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />   
    <style>
        .text-danger{
            font-size: 11px;
            font-weight: 800;
            font-style: italic;
        }
        .user-img {
            object-fit: cover;
        }
        input[type="checkbox"]{
            opacity: 0;
        }
        input[switch]:checked+label:after {
            left: 52px !important;
        }
        input[switch]+label:after {
            height: 17px !important;
            width: 17px !important;
            top: 3px !important;
            left: 4px !important;
        }
        input[switch]+label{
            width: 73px !important;
            height: 24px !important;
            margin-bottom: 0;
        }
    </style>  
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
                                <li class="breadcrumb-item active">Admin List</li>
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

                            <h4 class="card-title">Admin List</h4>
                            <div class="data table-responsive">
                                @if( $users->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Assing date</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; // Initialize counter variable
                                            @endphp
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    {{-- <td>
                                                        @if( !is_null($user->image) )
                                                            <img src="{{asset($user->image)}}" alt="" class="user-img">
                                                        @else
                                                            <img src="{{asset('backend/images/default.jpg')}}" alt="" class="user-img">
                                                        @endif
                                                    </td> --}}
                                                    <td>{{$user->name}}</td>
                                                    <td>
                                                        {{$user->email}}
                                                    </td>
                                                    <td>
                                                        {{ $user->created_at->format('d-M-Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if( $user->role_id == 1 )
                                                            <span class="badge bg-primary">Sub Admin</span>
                                                        @elseif( $user->role_id == 3 )
                                                            <span class="badge bg-secondary">Administrator</span>
                                                        @else
                                                            <span class="badge bg-dark">Super Admin</span>
                                                        @endif
                                                    </td>
                                                    <td align="middle">
                                                        @php
                                                            $switchId = 'switch' . $counter;
                                                        @endphp
                                                        @if( $user->id != 1 )
                                                            @if($user->status == 0)
                                                                <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $user->id }}" switch="success" />
                                                                <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                            @else
                                                                <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $user->id }}" switch="success" checked />
                                                                <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-warning" >not change able</span>
                                                        @endif
                                                    </td>
                                                    <td class="action"> 
                                                        {{-- <button>
                                                            <a href="" target="_blank">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </button> --}}
                                                        @if( isset($user->employees) || $user->id ==1 )
                                                        <button>
                                                            <a href="{{route('admin.admin-management.edit',$user->id)}}">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        </button>
                                                        @endif
                                                        @if( $user->id != 1 )
                                                        <button class="deleteButton" data-user-id="{{ $user->id }}">
                                                            <i class="ri-delete-bin-2-fill"></i>
                                                        </button>
                                                        @endif
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
    {{-- delete product --}}
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                
                var id = deleteButton.data('user-id');

                // Trigger SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this admin data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the product
                        $.ajax({
                            type: 'DELETE',
                            url: '/admin/admin-management/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                // Remove the row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });

                                setTimeout(() => {
                                    Swal.fire('Deleted!', 'Admin has been deleted.', 'success');
                                }, 1000);

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete admin.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- change status --}}
    <script>
        $(document).ready(function() {
            // Initialize toggle switches
            $('input[type="checkbox"]').each(function() {
                $(this).bootstrapToggle({
                    on: $(this).next('label').attr('data-on-label'),
                    off: $(this).next('label').attr('data-off-label')
                });
            });
        });

        $(document).ready(function() {
            $('.status-toggle').change(function() {
                var id = $(this).data('user-id');
                var status = $(this).prop('checked') ? 1 : 0;

                // Send AJAX request
                $.ajax({
                    type: 'PUT',
                    url: '/admin/admin-status/' + id, 
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