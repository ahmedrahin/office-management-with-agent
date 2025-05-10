@extends('backend.layout.template')
@section('page-title')
    <title>Course List || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.css">
    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />    
    <style>
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
                                <li class="breadcrumb-item active">Course List</li>
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
                                   All Course
                                </div>
                                <div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"> 
                                        <i class="bi bi-plus-circle"></i> Add new
                                    </button>                                    
                                </div>
                            </h4>
                            <div class="data table-responsive">
                                @if( $courses->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Course Name</th>
                                                <th>Enroll total</th>
                                                <th>Course Fees</th> 
                                                <th>Added by</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($courses as $course)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$course->name}}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $count = $course->assign->count();
                                                            $badgeClass = $count == 0 ? 'bg-danger' : ($count > 10 ? 'bg-success' : 'bg-primary');
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $count }}</span>
                                                    </td>
                                                    
                                                    <td class="text-center">{{ $course->fees ? $course->fees . 'tk' : '' }}</td> <!-- Display Fees -->
                                                    <td class="text-center">
                                                        <span class="badge bg-dark">{{ optional($course->user)->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <th>{{ $course->created_at ? $course->created_at->format('d, M, Y') : 'N/A' }}</th>


                                                    <td class="text-center">
                                                        @php
                                                            $switchId = 'switch' . $counter;
                                                        @endphp
                                                        @if($course->status == 0)
                                                            <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $course->id }}" switch="success" />
                                                            <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                        @else
                                                            <input type="checkbox" id="{{ $switchId }}" class="status-toggle" data-user-id="{{ $course->id }}" switch="success" checked />
                                                            <label for="{{ $switchId }}" data-on-label="Active" data-off-label="Inactive"></label>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('course.show', $course->id) }}" class="btn bg-primary text-white" style="font-size:13px;font-weight: 700;padding: 3px 8px;" target="_blank">
                                                            Details
                                                        </a>
                                                    </td>
                                                    <td class="action">
                                                        <button class="editCourseBtn" 
                                                                data-id="{{ $course->id }}" 
                                                                data-name="{{ $course->name }}" 
                                                                data-fees="{{ $course->fees }}"
                                                                data-start="{{ $course->start_time }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editCourseModal">
                                                            <i class="ri-edit-2-fill"></i>
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
                
    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Course Form -->
                    <form id="editCourseForm">
                        @csrf
                        <input type="hidden" id="editCourseId"> <!-- Hidden Course ID -->
                        <div class="mb-3">
                            <label for="editCourseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="editCourseName" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCourseFees" class="form-label">Course Fees</label>
                            <input type="number" step="0.01" class="form-control" id="editCourseFees" name="course_fees" required> <!-- Added Fees Field -->
                        </div>
                        <div class="mb-3">
                            <label for="start_edit" class="form-label">Class Start Time</label>
                            <input type="text"  class="form-control start" id="start_edit" name="start_time"> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateCourseBtn">Update Course</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Add Course Modal --}}
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Course Form -->
                    <form id="addCourseForm">
                        @csrf
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="courseName" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseFees" class="form-label">Course Fees</label>
                            <input type="number" step="0.01" class="form-control" id="courseFees" name="course_fees" required>
                        </div>
                        <div class="mb-3">
                            <label for="start" class="form-label">Class Start Time</label>
                            <input type="text"  class="form-control start" id="start" name="start_time"> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveCourseBtn">Save Course</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.js"></script>
    <script>
        $(document).ready(function() {
            // Handle the form submission
            $('#saveCourseBtn').click(function() {
                var courseName = $('#courseName').val();
                var courseFees = $('#courseFees').val();
                var start = $('#start').val();

                if (courseName.trim() === '' || courseFees.trim() === '') {
                    Swal.fire('Error!', 'Course name and fees cannot be empty.', 'error');
                    return;
                }

                // Send an AJAX request to save the course
                $.ajax({
                    type: 'POST',
                    url: '{{ route("course.store") }}', 
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        course_name: courseName,
                        course_fees: courseFees,
                        start_time: start,
                    },
                    success: function(response) {
                        // Close the modal and show success message
                        $('#addCourseModal').modal('hide');
                        Swal.fire('Success!', 'Course added successfully.', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        Swal.fire('Error!', 'Failed to add course. Please try again.', 'error');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('[name="start_time"]').prop('readonly', false);
            // When Edit button is clicked, fill the modal with course data
            $('.editCourseBtn').click(function () {
                let courseId = $(this).data('id');
                let courseName = $(this).data('name');
                let courseFees = $(this).data('fees');
                let start_edit = $(this).data('start');

                $('#editCourseId').val(courseId);
                $('#editCourseName').val(courseName);
                $('#editCourseFees').val(courseFees); 
                $('#start_edit').val(start_edit); 
            });

            // Handle Update Course Button Click
            $('#updateCourseBtn').click(function () {
                let courseId = $('#editCourseId').val();
                let courseName = $('#editCourseName').val();
                let courseFees = $('#editCourseFees').val();
                let start_edit = $('#start_edit').val();

                $.ajax({
                    url: "{{ route('course.update', '') }}/" + courseId,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_name: courseName,
                        course_fees: courseFees,
                        start_time: start_edit,
                    },
                    success: function (response) {
                        Swal.fire('Success!', 'Course updated successfully.', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function () {
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            function formatTimeWithLeadingZero(time) {
                const [hour, minuteWithPeriod] = time.split(':');
                const [minute, period] = minuteWithPeriod.split(' ');
                const formattedHour = hour.padStart(2, '0'); 
                return `${formattedHour}:${minute} ${period}`;
            }

            $('.start').mdtimepicker({
                theme: 'blue',
                time_24hr: false // 12-hour format
            }).on('timechanged', function (e) {
                const formattedTime = formatTimeWithLeadingZero(e.value);
                $(this).val(formattedTime); 
            });
            

            $('.end_time').mdtimepicker({
                theme: 'blue',
                time_24hr: false
            }).on('timechanged', function (e) {
                const formattedTime = formatTimeWithLeadingZero(e.value);
                $(this).val(formattedTime); 
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
                    url: '/admin/course-status/' + id, 
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
