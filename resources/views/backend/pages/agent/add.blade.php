@extends('backend.layout.template')
@section('page-title')
    <title>Add New Agent || {{ \App\Models\Settings::site_title() }}</title>
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
                                <li class="breadcrumb-item active">Add New Agent</li>
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
                                    Add New Agent
                                </div>
                                <div>
                                    <a href="{{ route('agent.index') }}" class="btn btn-primary">All Agent</a>
                                </div>
                            </h4>

                            <form action="{{route('agent.store')}}" method="POST" class="needs-validation"  novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Agent Name" name="name" required>
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
                                            <input type="text" id="phone" class="form-control" placeholder="Phone No." name="phone">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" placeholder="Address" name="address">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" id="password" placeholder="******" name="password" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="employeeImage" class="form-label">Employee Picture</label>
                                            <div class="employee-AppBody AppBody">
                                                <div class="icon">
                                                    <i class="fas fa-images"></i>
                                                </div>
                                                <h3 class="drag">Drag & Drop</h3>
                                                <span>OR</span>
                                                <button type="button" id="employeebrowseFile">Browse File</button>
                                                <input type="file" name="image" class="picture" hidden>
                                            </div>
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
                            <input type="file" name="image" class="picture" hidden>
                        `);

                        imgUpload('employee');
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

    </script>

@endsection