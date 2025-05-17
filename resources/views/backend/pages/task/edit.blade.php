@extends('backend.layout.template')
@section('page-title')
    <title>Add Task || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        .err {
            font-size: 83%;
            color: #f32f53;
            font-weight: 600 !important;
            margin-top: 7px !important;
        }
        .dateIcon {
            position: absolute;
            right: -2px;
            top: -0.5px;
            z-index: 0;
        }
        .dateBox {
            position: relative;
        }
    </style>
   
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/libs/select2/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.css">
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
                                <li class="breadcrumb-item active">Add Task</li>
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
                            <h4 class="card-title" style="display: flex;justify-content: space-between;align-items:center;">
                                <div>
                                    Add New Task
                                </div>
                                
                            </h4>

                            <form action="{{ route('task.update', $data->id) }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Task</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Task" name="task" value="{{ $data->tasks }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Employee</label>
                                            <select name="emp" class="form-control select2" required>
                                                <option value="">Select an employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ $data->employees_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} - {{ $employee->employee_office_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker"
                                                    name="date" value="{{ $data->date }}" autocomplete="off" required>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <div id="e_date_error" class="err"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Time (optional)</label>
                                            <input type="text" class="form-control start_time" name="start_time" id="start_time" value="{{ $data->time }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="vo" class="form-label">Note (optional)</label>
                                            <textarea id="elm1" placeholder="Write here.." name="note">{{ $data->note }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button class="btn btn-primary" type="submit" id="addExpense"> Update Task </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker/mdtimepicker.js"></script>

     {{-- data picker --}}
     <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
     {{-- select box --}}
     <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
     <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
    {{-- form editor --}}
    <script src="{{asset('backend/js/pages/form-editor.init.js')}}"></script>
    <script src="{{asset('backend/libs/tinymce/tinymce.min.js')}}"></script>

    <script>
         $('.start_time').mdtimepicker({
                theme: 'blue',
                time_24hr: false
            });
    </script>

    {{-- send data --}}
    <script>
        $(document).ready(function() {
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
                        $("#addExpense").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        `);
                    },
                    success: function(response) {
                        $("#addExpense").prop('disabled', false).html(`
                            Add Task
                        `);

                        $('.needs-validation')[0].reset();
                        $('.needs-validation').find('.form-control').removeClass('form-control');
                        $('.invalid-feedback').html('');

                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Add Task successfully!',
                        });

                       
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addExpense").prop('disabled', false).html('Add Task');

                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            var input = form.find('[name="' + key + '"]');
                            
                            // Check if input exists, if not, try to find by ID
                            if (input.length === 0) {
                                input = $('#' + key);
                            }

                            input.addClass('is-invalid');
                            if (input.next('.invalid-feedback').length > 0) {
                                input.next('.invalid-feedback').html(value[0]);
                            } else {
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            }
                        });
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