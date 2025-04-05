@extends('backend.layout.template')

@section('page-title')
    <title>Course Enrollment || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    
     <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/libs/select2/css/select2.min.css')}}" rel="stylesheet">
    <style>
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title span {
            font-weight: 800;
            font-size: 16px;
            display: block;
        }
    </style>
@endsection

@section('body-content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Course Enrollment</li>
                            </ol>
                            @if( Request::is('admin/assign-course') )
                                <span class="text-danger" pull-right>{{ request('month', date('M')) }}-{{ request('year', date('Y')) }}</span>
                            @else
                                <span class="text-danger" pull-right>{{date('d/M/Y')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Course Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title" style="display: flex;justify-content: space-between;align-items:center;">
                                <div>All Enrollment List</div>
                                <div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"> 
                                        <i class="bi bi-plus-circle"></i> Enroll Course
                                    </button>                                    
                                </div>
                            </h4>

                            <!-- Error or Success Message -->
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Table of Assignments -->
                            @if($assigns->count() == 0 )
                                <div class="alert alert-danger" role="alert">
                                    No Data Found!
                                </div>
                            @else
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl,</th>
                                            <th>Student Name</th>
                                            <th>Course Name</th>
                                            <th>Enroll Date</th>
                                            <th>Enrolled By</th>
                                            <th>Payment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assigns as $index => $assign)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $assign->registation->name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('course.show', $assign->course->id) }}" target="_blank" class="badge bg-info" style="color: white !important;">{{ $assign->course->name }}</a>
                                                </td>
                                                <td>{{ $assign->start_date }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-dark">{{ optional($assign->user)->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-success payment" href="{{ route('payment', $assign->id) }}">
                                                       Add Payment
                                                    </a>
                                                </td>
                                                <td class="action">
                                                    {{-- <button class="editAssignBtn"
                                                        data-id="{{ $assign->id }}"
                                                        data-student="{{ $assign->student_id }}"
                                                        data-course="{{ $assign->course_id }}"
                                                        data-start="{{ $assign->start_date }}">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </button> --}}
                                                    <button class="deleteButton" data-assign-id="{{ $assign->id }}">
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
            </div>

            <div class="row">
                {{-- Filter Other Months Data --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            @php
                                if( Request::is('admin/assign-course') ){
                                    $filterDate = "All";
                                } else {
                                    $month = (int) request('month', date('m')); 
                                    $year = (int) request('year', date('Y')); 
                                    $filterDate = "{$month}/{$year}";
                                }
                            @endphp
                            Show All Months {{ $year }} Enrollment Report
                        
                        </div>
                        <div class="card-body">
                            <div class="row monthlyExpense">
                                <div class="col-12">
                                    @php
                                        $currentMonth = date('n'); 
                                        $selectedYear = request('year'); 
                                        $selectedMonth = request('month');
                                        $currentYear = date('Y');
                                    @endphp
                                    
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $monthName = \Carbon\Carbon::create($selectedYear ?? $currentYear, $i, 1)->format('M');
                                            $disabled = ($selectedYear == $currentYear && $i > $currentMonth) ? 'disabled' : ''; 
                                            $buttonClass = ($selectedMonth && strtolower($selectedMonth) == strtolower($monthName)) ? 'btn-success' : 'btn-primary';
                                        @endphp
            
                                        <a href="{{ route('assign-course.index', ['month' => strtolower($monthName), 'year' => $selectedYear ?? $currentYear]) }}" 
                                           class="btn {{ $buttonClass }} {{ $disabled }}">
                                            {{ $monthName }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                @php
                    use Carbon\Carbon;
                    $hasYearSelected = request()->has('year');
                    $hasMonthSelected = request()->has('month');
                @endphp
            
                {{-- Year Selection --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <strong>Select Year</strong>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($allYear as $availableYear)
                                    <a href="{{ route('assign-course.index', ['year' => $availableYear, 'month' => Carbon::now()->format('M')]) }}" 
                                       class="btn btn-primary {{ request('year') == $availableYear ? 'btn-success text-white' : '' }}"
                                       style="width: 45%; text-align: center;">
                                        {{ $availableYear }}
                                    </a>
                                @endforeach

                                <a href="{{ route('assign-course.index') }}" 
                                   class="btn {{ ( Request::is('admin/assign-course') ) ? 'btn-success text-white' : 'btn-primary' }}"
                                   style="width: 45%; text-align: center;">
                                    All   
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
    </div>

    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Enroll Course to Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignCourseForm">
                        @csrf
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Select Student</label>
                            <select name="student_id" id="student_id" class="form-select select2" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Select Course</label>
                            <select name="course_id" id="course_id" class="form-control  select2" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3" id="datepicker1">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control" placeholder="dd M, yyyy"
                            data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" autocomplete="off" >
                        </div>
                        <button type="submit" class="btn btn-primary">Enroll Course</button>
                    </form>
                    <div id="responseMessage" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- SweetAlert and AJAX for Delete -->
    <script>
        
        $(document).ready(function() {
            $('.select2').select2({
                    width: '100%'
                });

                    $('#addCourseModal').on('shown.bs.modal', function () {
                $(this).find('.select2').select2({
                    width: '100%'
                });
            });
            $('#addCourseModal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                width: '100%',
                dropdownParent: $('#addCourseModal')  // Ensures the dropdown stays inside the modal
            });
        });

            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                var id = deleteButton.data('assign-id');

                // Confirm deletion with SweetAlert
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the assignment
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("assign-course.destroy", ":id") }}'.replace(':id', id),
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                // Remove the deleted row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted!', 'Assignment has been deleted.', 'success');
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire('Error!', 'Failed to delete.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

   

    <script>
        $(document).ready(function() {
            $('#assignCourseForm').submit(function(e) {
                e.preventDefault(); 
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("assign-course.store") }}',  
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#responseMessage').show().html('<div class="alert alert-success">Course Assigned Successfully!</div>');

                        $('#addCourseModal').modal('hide');
                        Swal.fire('Success!', 'Assigned successfully.', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log("Error Response: ", xhr.responseJSON);  // Debugging the error response
                        
                        var errorMessage = 'An unknown error occurred';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.error) {
                                // If there is a custom error message (like duplicate assignment), show it
                                errorMessage = xhr.responseJSON.error;
                            } else if (xhr.responseJSON.errors) {
                                // If there are validation errors, show the first one
                                var firstError = Object.values(xhr.responseJSON.errors)[0][0];
                                errorMessage = firstError;
                            } else if (xhr.responseJSON.message) {
                                // If a general message exists, show it
                                errorMessage = xhr.responseJSON.message;
                            }
                        }

                        Swal.fire('Error!', errorMessage, 'error');
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
