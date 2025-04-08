@extends('backend.layout.template')
@section('page-title')
    <title>Add New Job Type || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
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
                                <li class="breadcrumb-item active">Add New Job Type</li>
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
                                    Add New Job Type
                                </div>
                                <div>
                                    <a href="{{ route('job.index') }}" class="btn btn-primary addnew"> <i class="ri-arrow-left-line"></i> All Job Type</a>
                                </div>
                            </h4>

                            <form action="{{route('job.store')}}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="emp" class="form-label">Country</label>
                                            <select name="country_id" class="form-control select2" required>
                                                <option value="">Select a country</option>
                                               @foreach ($countries as $country)
                                                   <option value="{{ $country->id }}">{{ $country->name }}</option>
                                               @endforeach
                                            </select>
                                            <div id="emp" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Job Type Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Job Type Name" name="name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div>
                                    <button class="btn btn-primary" type="submit" id="addEmployee"> Save </button>
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
    <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

    {{-- send employess data --}}
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
                    contentType: false, 
                    processData: false, 
                    beforeSend: function(){
                        $("#addEmployee").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        `);
                    },
                    success: function(response) {
                        $("#addEmployee").prop('disabled', false).html(`
                            Save
                        `);
                        $('.needs-validation')[0].reset();
                        $('.needs-validation').find('.form-control').removeClass('form-control');
                        $('input').next('.invalid-feedback').html('');
                        $('#emp').html('');
                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addEmployee").prop('disabled', false).html(`
                            Save
                        `);
                        
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        console.log(errors)
                        $.each(errors, function(key, value) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.addClass('form-control');
                            input.next('.invalid-feedback').html(value); 

                            if (key === 'country_id') {
                                $('#emp').html(value);
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