@extends('backend.layout.template')
@section('page-title')
    <title>Add Admin || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        .AppBody {
            border: 3px dotted #d1d6d6;
            height: 300px;
            width: 100%;
            background-color: #fff;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
        }
        .AppBody.active {
            border: 3px solid #0f9cf3;
        }
        .icon {
            font-size: 50px;
            color: #0f9cf3;
        }
        .AppBody h3 {
            font-size: 23px;
            font-weight: 600;
            color: #333;
        }
        .AppBody span {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin: 6px 0 2px 0;
        }
        .AppBody button {
            padding: 10px 25px;
            font-size: 20px;
            font-weight: 500;
            border: none;
            outline: none;
            background: #fff;
            color: #0f9cf3;
            border-radius: 5px;
            cursor: pointer;    
        }
        .AppBody img{
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 11;
        }
        .cancell {
            font-weight: 800;
            font-size: 8px;
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
           cursor: pointer;
           z-index: 12;
        }
    </style>
     <link href="{{asset('backend/libs/select2/css/select2.min.css')}}" rel="stylesheet">
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
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Add Admin</li>
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
                            <h4 class="card-title">Add New Admin</h4>

                            <form action="{{route('admin.admin-management.store')}}" method="POST" class="needs-validation"  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="employee" class="form-label">Employee</label>
                                        <select name="employee_id" class="form-control select2" id="employee" data-placeholder="Select an employee" required>
                                            <option value="">Select an employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->employee_office_id }} 
                                                    @if($employee->position) ({{ $employee->position }}) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input id="name" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input id="email" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" id="">
                                                <option value="1" selected>Sub Admin</option>
                                                <option value="3">Administrator</option>
                                                <option value="2">Super Admin</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <button class="btn btn-primary" type="submit" id="addEmployee"> Create </button>
                                </div>
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
    <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>

    {{-- send employess data --}}
    <script>
        $(document).ready(function() {
            $('#employee').change(function() {
                var employeeId = $(this).val();
                
                if (employeeId) {
                    $.ajax({
                        url: '/get-employee/' + employeeId,
                        type: 'GET',
                        success: function(response) {
                            if (response) {
                                $('#name').val(response.name);
                                $('#email').val(response.email);
                            } else {
                                $('#name').val('');
                                $('#email').val('');
                            }
                        },
                        error: function() {
                            alert('Error fetching employee details');
                        }
                    });
                } else {
                    $('#name').val('');
                    $('#email').val('');
                }
            });
        });

         $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            $('.needs-validation').submit(function(event) {
                event.preventDefault(); 
                var form = $(this);
                var formData = new FormData(form[0]); 

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    contentType: false, // Don't set content type
                    processData: false, // Don't process the data
                    beforeSend: function(){
                        $("#addEmployee").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        `);
                    },
                    success: function(response) {
                        $("#addEmployee").prop('disabled', false).html(`
                            Create
                        `);
                        $('.needs-validation')[0].reset();
                        $('.needs-validation').find('.form-control').removeClass('form-control');

                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Admin created successfully!',
                        });

                        $('.AppBody').html(`
                            <div class="icon">
                                <i class="fas fa-images"></i>
                            </div>
                    
                            <h3 class="drag">Drag & Drop</h3>
                            <span>OR</span>
                            <button type="button" id="browseFile">Browse File</button>
                            <input type="file" name="image" class="picture" hidden>
                        `);
                        imgUpload();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addEmployee").prop('disabled', false).html(`Create`);

                        // Check if it's a validation error
                        if (xhr.status === 422) { 
                            var errors = xhr.responseJSON.errors;
                            console.log(errors);
                            
                            // Display validation errors next to the input fields
                            $.each(errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').html(value[0]); 
                            });

                            // Show SweetAlert for validation errors
                            var errorMessage = Object.values(errors).map(err => err[0]).join('<br>');
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                html: errorMessage,
                            });
                        } else {
                            // General error handling
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    }

                });
            });

            // Remove validation classes and messages on input change
            $('.needs-validation input').on('input', function() {
                var input = $(this);
                input.removeClass('is-invalid');
                input.next('.invalid-feedback').html('');
            });
        });
    </script>

@endsection