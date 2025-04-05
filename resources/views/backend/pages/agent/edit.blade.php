@extends('backend.layout.template')
@section('page-title')
    <title>Edit Employee || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
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
            font-size: 18px;
            position: absolute;
            top: 10px;
            right: 10px;
            /* background: red; */
            color: red;
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
                                <li class="breadcrumb-item active">Edit Employee</li>
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
                            <h4 class="card-title">Edit Employee</h4>
                            {{-- edit data --}}
                            <div id="edit-data">
                                <form action="{{route('update.employees', $editData->id)}}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="validationName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="validationName" placeholder="Employees Name" value="{{$editData->name}}" name="name" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="validationEamil" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="validationEamil" value="{{$editData->email}}" placeholder="Enter Email" name="email" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone No.</label>
                                                <input type="text" id="phone" class="form-control" placeholder="Phone No." value="{{$editData->phone}}" name="phone" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="id" class="form-label">.#ID</label>
                                                <input type="text" id="id" class="form-control" placeholder="id" name="id" value="{{ $editData->employee_office_id }}" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="hours" class="form-label">Office Hours (schedule) </label>
                                                <select name="schedule_id" id="">
                                                    <option value="">Select a schedule</option>
                                                    @foreach ($shedules as $shedule)
                                                        <option value="{{ $shedule->id }}" {{ $shedule->id == $editData->schedule_id ? 'selected' : '' }}>{{ $shedule->name }}  ({{ $shedule->start_time }} - {{ $shedule->end_time }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="birth" class="form-label">Join Date</label>
                                                <div class="input-group" id="datepicker1">
                                                    <input type="text" name="join_date" class="form-control" placeholder="dd M, yyyy"
                                                        data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" autocomplete="off" value="{{ $editData->join_date }}" >
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
                                                <input type="text" id="salary" placeholder="Salary" value="{{$editData->salary}}" name="salary" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="vo" class="form-label">Position</label>
                                                <input type="text" id="position" placeholder="position" value="{{$editData->position}}" name="position">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" id="address" placeholder="Address" value="{{$editData->address}}" name="address">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Employee Image Section -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="employeeImage" class="form-label">Employee Picture</label>
                                                <div class="employee-AppBody AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                    
                                                    <h3 class="drag">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="employeeBrowseFile">Browse File</button>
                                                    <input type="file" name="employeeImage" class="picture" hidden>
                                    
                                                    <!-- Existing Employee Image -->
                                                    @if(!is_null($editData->image))
                                                        <img src="{{ asset($editData->image) }}" alt="Employee Image" id="employeeEditImg">
                                                        <div class="cancell" id="employeeEditCan">❌</div>
                                                        <input type="hidden" name="employeeHasRemove" id="employeeHasRemove">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Sign Image Section -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="signImage" class="form-label">Sign Picture</label>
                                                <div class="sign-AppBody AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                    
                                                    <h3 class="drag">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="signBrowseFile">Browse File</button>
                                                    <input type="file" name="signImage" class="picture" hidden>
                                    
                                                    <!-- Existing Sign Image -->
                                                    @if(!is_null($editData->sign))
                                                        <img src="{{ asset($editData->sign) }}" alt="Sign Image" id="signEditImg">
                                                        <div class="cancell" id="signEditCan">❌</div>
                                                        <input type="hidden" name="signHasRemove" id="signHasRemove">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                
                                    <div>
                                        <button class="btn btn-primary" type="submit" id="addEmployee"> Save Changes </button>
                                    </div>
                                </form>
                            </div>
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
                            Save Changes
                        `);
                        
                        $('.needs-validation').find('.form-control').removeClass('form-control');

                        //update form data
                        $('#validationName').val(response.editData.name);
                        $('#validationEamil').val(response.editData.email);
                        $('#phone').val(response.editData.phone);
                        $('#address').val(response.editData.address);
                        $('#salary').val(response.editData.salary);
                        $('#city').val(response.editData.city);
                        $('#Experiance').val(response.editData.experience);
                        $('#vo').val(response.editData.vacation);

                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Information Updated!',
                        });
                        imgUpload();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addEmployee").prop('disabled', false).html(`
                             Save Changes
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
    let btn = document.querySelector(`#${imageType}BrowseFile`);
    let input = dragArea.querySelector('.picture');
    let file;

    // Handle the Browse button click
    btn.onclick = () => {
        input.click();
    };

    // Handle file selection change (via Browse button)
    input.addEventListener('change', function () {
        file = this.files[0];
        show();
    });

    // Handle drag over event (for drag-and-drop)
    dragArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dragText.innerText = "Release to Upload File";
        dragArea.classList.add('active');
    });

    // Handle drag leave event (when dragging out of the area)
    dragArea.addEventListener('dragleave', () => {
        dragText.innerText = "Drag & Drop";
        dragArea.classList.remove('active');
    });

    // Handle drop event (when a file is dropped into the area)
    dragArea.addEventListener('drop', (event) => {
        event.preventDefault();
        file = event.dataTransfer.files[0];
        input.files = event.dataTransfer.files; // Set files to input
        show();
    });

    // Display the selected image (preview) or show an error if invalid file type
    function show() {
        let fileType = file.type;
        let validType = ['image/jpeg', 'image/jpg', 'image/png'];

        if (validType.includes(fileType)) {
            let fileRead = new FileReader();
            fileRead.onload = () => {
                let imgUrl = fileRead.result;
                let img = `<img src="${imgUrl}">`;
                let cancelButton = `<div class="cancell">❌</div>`;

                // Create a new div for the uploaded image and cancel button
                let imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');
                imageContainer.innerHTML = img + cancelButton;

                // Check if an image is already uploaded
                let existingImageContainer = dragArea.querySelector('.image-container');
                if (existingImageContainer) {
                    // Remove the existing image container
                    dragArea.removeChild(existingImageContainer);
                }
                dragArea.appendChild(imageContainer);
            };
            fileRead.readAsDataURL(file);
        } else {
            alert('This file is not valid');
            dragArea.classList.remove('active');
            dragText.innerText = "Drag & Drop";
        }
    }

    // Event delegation for cancel button (remove the uploaded image)
    dragArea.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('cancell')) {
            // Clear the input file and remove the image container
            input.value = null;
            dragArea.classList.remove('active');
            dragText.innerText = "Drag & Drop";
            let imageContainer = event.target.closest('.image-container');
            if (imageContainer) {
                dragArea.removeChild(imageContainer);
            }
        }
    });

    // Employee image cancellation
    if (imageType === 'employee') {
        $('#employeeEditCan').on('click', function () {
            $('#employeeEditImg').remove(); // Remove the existing employee image
            $('#employeeHasRemove').val(1);  // Mark that the image should be removed
            $(this).remove(); // Remove the cancel button
            imgUpload('employee'); // Reinitialize the employee image upload functionality
        });
    }

    // Sign image cancellation
    if (imageType === 'sign') {
        $('#signEditCan').on('click', function () {
            $('#signEditImg').remove(); // Remove the existing sign image
            $('#signHasRemove').val(1);  // Mark that the image should be removed
            $(this).remove(); // Remove the cancel button
            imgUpload('sign'); // Reinitialize the sign image upload functionality
        });
    }
}

// Initialize the image upload functionality for both Employee and Sign images
imgUpload('employee');
imgUpload('sign');

    </script>

@endsection