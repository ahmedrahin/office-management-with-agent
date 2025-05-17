@extends('backend.layout.template')
@section('page-title')
    <title>Week Task List || {{ \App\Models\Settings::site_title() }} </title>
@endsection

@section('page-css')
    {{-- custom --}}
    <style>
        td p {
            margin: 0 !important;
        }
        .card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-group {
            padding: 0 !important;
        }
        a:focus {
            box-shadow: none !important;
        }
        blockquote h4{
            font-size: 13px;
            font-weight: 700;
        }
    </style>
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
@endsection

@section('body-content')

    @php
        use Carbon\Carbon;
    @endphp

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
                                <li class="breadcrumb-item active">Week Tasks</li>
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

                            <h4 class="card-title">
                                Week Task List
                                <div class="btn btn-group">
                                    <a href="{{route('task.index', [date('Y'), (Carbon::now()->format('M'))])}}" class="btn btn-primary" >All</a>
                                    <a href="{{route('task.today')}}" class="btn btn-primary" >Today Tasks</a>
                                    <a href="{{route('task.week')}}" class="btn btn-primary" style="background: #0c7dc2;">This Week Tasks</a>
                                </div>
                            </h4>
                            <div class="data table-responsive">
                                @if( $data->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Task</th>
                                                
                                                <th class="text-center">Assign To</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Time</th>
                                                <th class="text-center">Added by</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; 
                                                
                                            @endphp
                                            @foreach ($data as $v)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{ $v->tasks }}</td>
                                                    <td class="text-center">{{ $v->employees->name }}</td>
                                                    <td class="text-center">{{ $v->date }}</td>
                                                    <td class="text-center">{{ $v->time ?? '-' }}</td>
                                                    <td class="text-center"><span class="badge bg-dark">{{ optional($v->user)->name ?? 'N/A' }}</td>
                                                   <td class="text-center">
                                                        @if($v->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($v->status == 're-schedule')
                                                            <span class="badge bg-info">Re-schedule</span>
                                                        @elseif($v->status == 'complete')
                                                            <span class="badge bg-success">Complete</span>
                                                        @else
                                                            <span class="badge bg-secondary">Unknown</span>
                                                        @endif
                                                    </td>

                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('task.edit',$v->id)}}">
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
    {{-- delete expense --}}
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                
                var id = deleteButton.data('id');

                // Trigger SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this task data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("task.destroy", ":id") }}'.replace(':id', id),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                // Remove the row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });

                                setTimeout(() => {
                                    Swal.fire('Deleted!', 'Task has been deleted.', 'success');
                                }, 1000);

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete.', 'error');
                            }
                        });
                    }
                });
            });

            $(document).ready(function() {
                $('#datepicker6').datepicker({
                    format: "dd M, yyyy",
                    autoclose: true
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