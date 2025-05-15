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
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Agent Name" name="name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationEamil" class="form-label">Email</label>
                                            <input type="email"  id="validationEamil" placeholder="Enter Email" name="email" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>


                                </div>


                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone No.</label>
                                            <input type="text" id="phone" class="form-control" placeholder="Phone No." name="phone">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" id="password" placeholder="******" name="password" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                 {{-- NEW FIELDS START --}}

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father's Name</label>
                                            <input type="text" id="father_name" class="form-control" placeholder="Father's Name" name="father_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mother_name" class="form-label">Mother's Name</label>
                                            <input type="text" id="mother_name" class="form-control" placeholder="Mother's Name" name="mother_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="spouse_name" class="form-label">Spouse Name (if applicable)</label>
                                            <input type="text" id="spouse_name" class="form-control" placeholder="Spouse Name" name="spouse_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="village" class="form-label">Village</label>
                                            <input type="text" id="village" class="form-control" placeholder="Village" name="village">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="ward_no" class="form-label">Ward No</label>
                                            <input type="text" id="ward_no" class="form-control" placeholder="Ward No" name="ward_no">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="sub_district" class="form-label">Upazila (Sub-district)</label>
                                            <input type="text" id="sub_district" class="form-control" placeholder="Upazila" name="sub_district">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="district" class="form-label">District</label>
                                            <input type="text" id="district" class="form-control" placeholder="District" name="district">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="division" class="form-label">Division</label>
                                            <input type="text" id="division" class="form-control" placeholder="Division" name="division">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nid_number" class="form-label">NID Number</label>
                                            <input type="text" id="nid_number" class="form-control" placeholder="NID Number" name="nid_number">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="passport_number" class="form-label">Passport Number</label>
                                            <input type="text" id="passport_number" class="form-control" placeholder="Passport Number" name="passport_number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="current_address" class="form-label">Current Address</label>
                                            <textarea id="current_address" class="form-control" rows="3" placeholder="Current Address" name="current_address"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="permanent_address" class="form-label">Permanent Address</label>
                                            <textarea id="permanent_address" class="form-control" rows="3" placeholder="Permanent Address" name="permanent_address"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="education_qualification" class="form-label">Educational Qualification</label>
                                            <input type="text" id="education_qualification" class="form-control" placeholder="Educational Qualification" name="education_qualification">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="study_institute" class="form-label">Institute / Study</label>
                                            <input type="text" id="study_institute" class="form-control" placeholder="Institute and Study Details" name="study_institute">
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Previous Experience as Agent?</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input p-0" type="radio" name="previous_experience" id="experience_yes" value="1">
                                                <label class="form-check-label" for="experience_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input p-0" type="radio" name="previous_experience" id="experience_no" value="0" checked>
                                                <label class="form-check-label" for="experience_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="experience_years" class="form-label">Years of Experience</label>
                                            <input type="number" min="0" id="experience_years" class="form-control" placeholder="Years of Experience" name="experience_years">
                                        </div>
                                    </div>
                                </div>

                                {{-- NEW FIELDS END --}}

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="employeeImage" class="form-label">Agent Picture</label>
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
                            text: 'Agent added successfully!',
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
