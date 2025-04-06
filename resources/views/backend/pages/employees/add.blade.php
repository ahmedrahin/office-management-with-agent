@extends('backend.layout.template')
@section('page-title')
    <title>Add Employee || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
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
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Add Employee</li>
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
                                    Add New Employee
                                </div>
                                <div>
                                    <a href="{{ route('manage.employees') }}" class="btn btn-primary">All Employees</a>
                                </div>
                            </h4>

                            <form action="{{route('store.employees')}}" method="POST" class="needs-validation"  novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Employees Name" name="name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationEamil" class="form-label">Email</label>
                                            <input type="email"  id="validationEamil" placeholder="Enter Email" name="email" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone No.</label>
                                            <input type="text" id="phone" class="form-control" placeholder="Phone No." name="phone" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="id" class="form-label">Employee ID</label>
                                            <input type="text" id="id" class="form-control" placeholder="Id" name="id" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hours" class="form-label">Office Hours (schedule) </label>
                                            <select name="schedule_id" id="">
                                                <option value="">Select a schedule</option>
                                                @foreach ($shedules as $shedule)
                                                    <option value="{{ $shedule->id }}">{{ $shedule->name }}  ({{ $shedule->start_time }} - {{ $shedule->end_time }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="birth" class="form-label">Join Date</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" name="join_date" class="form-control" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" autocomplete="off" >
                                                    <div class="invalid-feedback"></div>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="salary" class="form-label">Salary</label>
                                            <input type="text" id="salary" placeholder="Salary" name="salary" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="position" class="form-label">Position</label>
                                            <input type="text" id="position" placeholder="position" name="position">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" placeholder="Address" name="address">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="employeeImage" class="form-label">Employee Picture</label>
                                            <div class="employee-AppBody AppBody">
                                                <div class="icon">
                                                    <i class="fas fa-images"></i>
                                                </div>
                                                <h3 class="drag">Drag & Drop</h3>
                                                <span>OR</span>
                                                <button type="button" id="employeebrowseFile">Browse File</button>
                                                <input type="file" name="employeeImage" class="picture" hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="signImage" class="form-label">Sign Picture</label>
                                            <div class="sign-AppBody AppBody">
                                                <div class="icon">
                                                    <i class="fas fa-images"></i>
                                                </div>
                                                <h3 class="drag">Drag & Drop</h3>
                                                <span>OR</span>
                                                <button type="button" id="signbrowseFile">Browse File</button>
                                                <input type="file" name="signImage" class="picture" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <button class="btn btn-primary" type="submit" id="addEmployee"> Add Employees </button>
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
                            Add Employees
                        `);
                        $('.needs-validation')[0].reset();
                        $('.needs-validation').find('.form-control').removeClass('form-control');

                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Employee added successfully!',
                        });

                        $('.employee-AppBody').html(`
                            <div class="icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <h3 class="drag">Drag & Drop</h3>
                            <span>OR</span>
                            <button type="button" id="employeebrowseFile">Browse File</button>
                            <input type="file" name="employeeImage" class="picture" hidden>
                        `);

                        // Reset the Sign Image Upload area (AppBody)
                        $('.sign-AppBody').html(`
                            <div class="icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <h3 class="drag">Drag & Drop</h3>
                            <span>OR</span>
                            <button type="button" id="signbrowseFile">Browse File</button>
                            <input type="file" name="signImage" class="picture" hidden>
                        `);

                        imgUpload('employee');
                        imgUpload('sign');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addEmployee").prop('disabled', false).html(`
                            Add Employees
                        `);
                        
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        console.log(errors)
                        $.each(errors, function(key, value) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.addClass('form-control');
                            input.next('.invalid-feedback').html(value); 
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

    {{-- drag & drop --}}
    <script>
       function imgUpload(imageType) {
            let dragArea = document.querySelector(`.${imageType}-AppBody`);
            let dragText = dragArea.querySelector('.drag');
            let btn = document.querySelector(`#${imageType}browseFile`);
            let input = dragArea.querySelector('.picture');
            let file;

            btn.onclick = () => {
                input.click();
            }

            input.addEventListener('change', function () {
                file = this.files[0];
                show();
            });

            dragArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dragText.innerText = "Release to Upload File";
                dragArea.classList.add('active');
            });

            dragArea.addEventListener('dragleave', () => {
                dragText.innerText = "Drag & Drop";
                dragArea.classList.remove('active');
            });

            dragArea.addEventListener('drop', (event) => {
                event.preventDefault();
                file = event.dataTransfer.files[0];
                input.files = event.dataTransfer.files; // Set files to input
                show();
            });

            function show() {
                let fileType = file.type;
                let validType = ['image/jpeg', 'image/jpg', 'image/png'];

                if (validType.includes(fileType)) {
                    let fileRead = new FileReader();
                    fileRead.onload = () => {
                        let imgUrl = fileRead.result;
                        let img = `<img src="${imgUrl}">`;
                        let cancelButton = `<div class="cancell">❌</div>`;
                        
                        let imageContainer = document.createElement('div');
                        imageContainer.classList.add('image-container');
                        imageContainer.innerHTML = img + cancelButton;
                        
                        let existingImageContainer = dragArea.querySelector('.image-container');
                        if (existingImageContainer) {
                            dragArea.removeChild(existingImageContainer);
                        }
                        dragArea.appendChild(imageContainer);
                        
                        let cancelButtonElement = imageContainer.querySelector('.cancell');
                        cancelButtonElement.addEventListener('click', function () {
                            input.value = null;
                            dragArea.classList.remove('active');
                            dragText.innerText = "Drag & Drop";
                            dragArea.removeChild(imageContainer);
                        });
                    }
                    fileRead.readAsDataURL(file);
                } else {
                    alert('This file is not valid');
                    dragArea.classList.remove('active');
                    dragText.innerText = "Drag & Drop";
                }
            }
        }

        // Initialize both upload functionalities
        imgUpload('employee');
        imgUpload('sign');

    </script>

@endsection