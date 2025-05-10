@extends('backend.layout.template')
@section('page-title')
    <title>Work Schedules || {{ \App\Models\Settings::site_title() }}</title>
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
                                <li class="breadcrumb-item active">Work Schedules</li>
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
                                    Work Schedules
                                </div>
                                <div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"> 
                                        <i class="bi bi-plus-circle"></i> Add new
                                    </button>                                    
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
                                                <th>Schedule Name</th>
                                                <th>Assign total</th>
                                                <th>Start Time</th> 
                                                <th>End Time</th>
                                                <th>Total Hours</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($data as $v)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$v->name}}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $count = $v->employees->count();
                                                            $badgeClass = $count == 0 ? 'bg-danger' : ($count > 10 ? 'bg-success' : 'bg-primary');
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $count }}</span>
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        {{$v->start_time}}
                                                    </td> 
                                                    <td class="text-center">
                                                        {{$v->end_time}}
                                                    </td> 

                                                    <td class="text-center">
                                                       <span class="badge bg-warning">{{ $v->total_time }}</span>
                                                    </td>
                                                
                                                    <td class="action">
                                                        <button class="editCourseBtn" 
                                                                data-id="{{ $v->id }}" 
                                                                data-name="{{ $v->name }}" 
                                                                data-start="{{ $v->start_time }}"
                                                                data-end="{{ $v->end_time }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editCourseModal">
                                                            <i class="ri-edit-2-fill"></i>
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
                
    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Course Form -->
                    <form id="editCourseForm">
                        @csrf
                        <input type="hidden" id="course_id" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Schedule Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="text" class="form-control start_time" id="start_time_edit" name="start_time">
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="text" class="form-control end_time" id="end_time_edit" name="end_time">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateCourseBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Course Modal --}}
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Course Form -->
                    <form id="scheduleForm">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        
                        <div class="mb-3">
                            <label for="shudleName" class="form-label">Schedule Name</label>
                            <input type="text" class="form-control" id="shudleName" name="name">
                        </div>
                    
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="text" class="form-control start_time" name="start_time" id="start_time">
                        </div>
                    
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="text" class="form-control end_time" name="end_time" id="end_time">
                        </div>
                    
                        <div class="modal-footer pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save Schedule</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.js"></script>
    <script>
        $(document).ready(function () {
            $('#saveBtn').click(function (e) {
                e.preventDefault();

                let startTime = $('#start_time').val();  
                let endTime = $('#end_time').val();      

                // Prepare the form data
                let formData = {
                    name: $('#shudleName').val(),
                    start_time: startTime, 
                    end_time: endTime,     
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route("shedule.store") }}',
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Schedule added successfully.',
                            icon: 'success'
                        }).then(() => {
                            $('#addCourseModal').modal('hide');
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            for (let field in errors) {
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }

                            Swal.fire({
                                title: 'Validation Error!',
                                html: `<div style="line-height:1.8;">${errorMessages}</div>`,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
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

            $('.start_time').mdtimepicker({
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

    <script>
        $(document).ready(function() {
            let id = null;
            // When the edit button is clicked
            $('.editCourseBtn').click(function() {
                 id = $(this).data('id');
                const name = $(this).data('name');
                const startTime = $(this).data('start');
                const endTime = $(this).data('end');
                
                // Populate the modal with current course data
                $('#course_id').val(id);
                $('#name').val(name);
                $('#start_time_edit').val(startTime);
                $('#end_time_edit').val(endTime);
            });

            // Handle the update form submission
            $('#updateCourseBtn').click(function(e) {
                e.preventDefault();

                const formData = {
                    id: $('#course_id').val(),
                    name: $('#name').val(),
                    start_time: $('#start_time_edit').val(),
                    end_time: $('#end_time_edit').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                // Send the update request via AJAX
                $.ajax({
                    type: 'PUT',
                    url: "{{ route('shedule.update', '') }}/" + id,
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Updated successfully.',
                            icon: 'success'
                        }).then(() => {
                            $('#editCourseModal').modal('hide');
                            location.reload(); 
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            for (let field in errors) {
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }

                            Swal.fire({
                                title: 'Validation Error!',
                                html: `<div style="line-height:1.8;">${errorMessages}</div>`,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
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
    

    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                
                var expenseId = deleteButton.data('id');

                // Trigger SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this income data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the customer
                        $.ajax({
                            type: 'DELETE',
                           url: '{{ route("shedule.destroy", ":id") }}'.replace(':id', expenseId),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                // Remove the row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });
                                // $('.exp_info').html(response.html)
                                setTimeout(() => {
                                    Swal.fire('Deleted!', 'Schedule has been deleted.', 'success');
                                }, 1000);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete Income.', 'error');
                            }
                        });
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
