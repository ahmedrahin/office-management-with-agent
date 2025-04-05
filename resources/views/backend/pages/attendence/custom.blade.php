@extends('backend.layout.template')
@section('page-title')
    <title>Take Attendence || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
    <style>
        input[type="radio"]{
            padding: 0 !important;
        }
        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table label i {
            padding-left: 6px;
        }
        
        table label {
            display: flex;
            align-items: center;
        }
        .ri-checkbox-circle-line {
            color: #03c003;
            padding-left: 12px;
        }
        .ri-close-circle-line {
            color: #ff0000ba;
        }
        
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title span {
            font-weight: 800;
            font-size: 16px;
        }
    </style>
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection

@section('body-content')

    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Take Attendence</li>
                            </ol>
                        </div>


                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('store.custom.attendance')}}" method="POST" class="needs-validation">
                            @csrf
                                <h4 class="card-title">
                                    Take Attendence
                                    <div class="d-flex align-items-center flex-wrap" style="cursor: pointer; gap: 10px; justify-content: end;">
                                    
                                        <div class="d-flex align-items-center badge bg-danger px-2 ">
                                            <label for="holiday" class="mb-0 d-block text-white" style="font-size: 16px; cursor: pointer;">Holiday</label>
                                            <input type="checkbox" name="holiday" id="holiday" style="width: 22px; height: 22px; cursor: pointer; margin-left: 5px;" value="1">
                                        </div>
                                    
                                        <!-- Submit Button -->
                                        <button class="btn btn-success" type="button" id="submitAttendance">Submit Attendance</button>

                                        <div class="input-group" id="datepicker1" style="width: 50%;">
                                            <input type="text" class="form-control" placeholder="dd M, yyyy" 
                                                data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" 
                                                name="date" autocomplete="off">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                    
                                </h4>

                                @if( $employees->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Employee Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Image</th>
                                                <th>#ID</th>
                                                <th>Name</th>
                                                <th>Attendence</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>
                                                        @if( !is_null($employee->image) )
                                                            <img src="{{asset($employee->image)}}" alt="" class="user-img">
                                                        @else
                                                            <img src="{{asset('backend/images/user.jpg')}}" alt="" class="user-img">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $employee->employee_office_id }}</span>
                                                    </td>
                                                    <td>{{$employee->name}} {{$employee->position ? '(' . $employee->position .')'  : ''}}</td>
                                                    
                                                    <td>
                                                        <input type="hidden" name="emp[]" value="{{$employee->id}}">
 <!-- #region -->
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="att[{{$employee->id}}]" id="present{{$employee->id}}" value="present">
                                                            <label class="form-check-label" for="present{{$employee->id}}">
                                                                Present <i class="ri-checkbox-circle-line"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check absence-box mb-2">
                                                            <input class="form-check-input" type="radio" name="att[{{$employee->id}}]" id="absence{{$employee->id}}" value="absence">
                                                            <label class="form-check-label" for="absence{{$employee->id}}">
                                                                Absence <i class="ri-close-circle-line"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input holiday-radio-input" type="radio" name="att[{{$employee->id}}]" id="holiday{{$employee->id}}" value="holiday">
                                                            <label class="form-check-label" for="holiday{{$employee->id}}">
                                                                Holiday <i class="ri-close-circle-line"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </form>
                           
                        </div>
                    </div>
                    <!-- end card -->
                </div> 
            </div>
            <!-- end row -->

        </div> 
    </div>
    <!-- End Page-content -->
                
@endsection

@section('page-script')
    <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
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

    {{-- send attendance data --}}
    <script>
        $(document).ready(function() {
            $('#submitAttendance').click(function() {
                // Serialize the form data
                var formData = $('form.needs-validation').serialize();

                // Send an AJAX request
                $.ajax({
                    type: 'POST',
                    url: $('form.needs-validation').attr('action'),
                    data: formData,
                    beforeSend: function(){
                        $("#submitAttendance").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        `);
                        $("#submitAttendance").css('width', '166px')
                    },
                    success: function(response) {
                        $("#submitAttendance").prop('disabled', false).html(`
                            Submited Attendance
                        `);
                        $("#submitAttendance").css('width', '166px')
                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Submited Attendance successfully!',
                        });

                        setTimeout(() => {
                            window.location = ('/admin/attendence/manage');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        // Enable the submit button
                        $("#submitAttendance").prop('disabled', false).html('Submit Attendance');

                        console.error(xhr.responseText); // Log error for debugging

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors; // Laravel validation errors
                            let errorMessage = "";

                            // Check if it's a validation error
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    errorMessage += value[0] + "\n"; // Get the first error message for each field
                                });
                            } else {
                                errorMessage = xhr.responseJSON.error; // Custom error (e.g., attendance already taken)
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage,
                            });
                        } else {
                            // Handle other errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while submitting attendance.',
                            });
                        }
                    }



                });
            });
        });

        $(document).ready(function() {
            $('#holiday').change(function() {
                if ($(this).prop('checked')) {
                    // When checkbox is checked, select all holiday radio buttons
                    $('.holiday-radio-input').prop('checked', true);
                    $('.absence-box').css('display', 'none');
                } else {
                    // When checkbox is unchecked, deselect all holiday radio buttons
                    $('.holiday-radio-input').prop('checked', false);
                    $('.absence-box').css('display', 'block');
                }
            });
        });
    </script>

@endsection