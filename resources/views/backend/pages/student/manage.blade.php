@extends('backend.layout.template')
@section('page-title')
    <title>Manage Register Student || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
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
                                <li class="breadcrumb-item active">All Register Student</li>
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
                                    Manage Student ({{ $students->count() }})
                                </div>
                                <div>

                                    <a href="{{ route('student-registration.create') }}" class="btn btn-primary addnew"> <i class="ri-add-line"></i> Register New</a>
                                </div>
                            </h4>
                            <div class="data table-responsive">
                                @if( $students->count() == 0 )
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
                                                <th>Country</th>
                                                <th>University/Subject</th>
                                                <th>Mobile no.</th>
                                                <th>Total Cost</th>
                                                <th>Added by</th>
                                                <th>Register Date</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td class="text-center">
                                                        @if( !is_null($student->image) )
                                                            <img src="{{asset($student->image)}}" alt="" class="user-img">
                                                        @else
                                                            <img src="{{asset('backend/images/user.jpg')}}" alt="" class="user-img">
                                                        @endif
                                                    </td>
                                                    <td>{{$student->name}}</td>
                                                    <td>
                                                       {{ optional($student->country)->name }}
                                                    </td>
                                                    <td>
                                                        {{ optional($student->university)->name }} {{ isset($student->subject) ? '/ sub:' . $student->subject->name : '' }}
                                                   </td>

                                                    <td>{{ $student->mobile }}</td>
                                                        @php
                                                            $lastPayments = $student->assign->map(function ($assignment) {
                                                                return $assignment->payment->sortByDesc('created_at')->first();
                                                            })->filter();

                                                            $totalDue = $lastPayments->sum('due_payment');
                                                        @endphp

                                                        <td align="middle">
                                                            {{ $student->total_cost }}BDT
                                                        </td>

                                                    <td class="text-center">
                                                        <span class="badge bg-dark">
                                                            @if( $student->user_id )
                                                                {{ optional($student->user)->name ?? 'N/A' }}
                                                            @else
                                                                {{ optional($student->agent)->name ?? 'N/A' }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="text-center">{{ $student->created_at->format('d M Y') }}</td>

                                                    <td class="text-center">
                                                        <a href="{{ route('student-registration.show', $student->id) }}" class="btn bg-primary text-white" style="font-size:13px;font-weight: 700;padding: 3px 8px;" target="_blank">
                                                            Details
                                                        </a>
                                                    </td>

                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('student-registration.edit',$student->id)}}">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        </button>
                                                        <button class="deleteButton" data-student-id="{{ $student->id }}">
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

           <div class="row">
                <div class="col-md-5">
                    <div>
                        <label class="form-label">Filter By Date</label>
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('student-registration.index') }}" id="filterForm" style="margin-bottom: 30px;">
                            <div class="input-daterange input-group mb-2" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true">
                                <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="{{ request('start_date') }}" autocomplete="off" />
                                <input type="text" class="form-control" name="end_date" placeholder="End Date" value="{{ request('end_date') }}" autocomplete="off" />
                            </div>

                            <div class="mb-2">
                                <select name="user_type" class="form-select">
                                    <option value="">Select admin type</option>
                                    <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>By Admin</option>
                                    <option value="agent" {{ request('user_type') == 'agent' ? 'selected' : '' }}>By Agent</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Filter</button>

                            @if(request('start_date') || request('end_date') || request('user_type'))
                                <a href="{{ route('student-registration.index') }}" class="btn btn-secondary mt-2">Show All</a>
                            @endif
                        </form>

                    </div>
                </div>
           </div>

        </div>
    </div>
    <!-- End Page-content -->

@endsection

@section('page-script')
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    {{-- delete employee --}}
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this);

                var id = deleteButton.data('student-id');

                // Trigger SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this student data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the employee
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("student-registration.destroy", ":id") }}'.replace(':id', id),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Remove the row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });

                                setTimeout(() => {
                                    Swal.fire('Deleted!', 'Student has been deleted.', 'success');
                                }, 1000);

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete student.', 'error');
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
