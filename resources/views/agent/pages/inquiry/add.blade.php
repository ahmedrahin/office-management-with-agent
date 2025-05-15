@extends('agent.layout.template')
@section('page-title')
    Job Inquiry Register Form 
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
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
                                <li class="breadcrumb-item active">Job Inquiry Register Form</li>
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
                                    Add New Job Inquiry Person
                                </div>
                                <div>
                                    <a href="{{ route('agent-person.index') }}" class="btn btn-primary addnew"> <i class="ri-arrow-left-line"></i> View All</a>
                                </div>
                            </h4>

                            <form action="{{route('agent-person.store')}}" method="POST" class="needs-validation"  novalidate enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Person Name" name="name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father Name</label>
                                            <input type="text"  id="father_name" placeholder="Father Name" name="father_name">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mother_name" class="form-label">Mother Name</label>
                                            <input type="text"  id="mother_name" placeholder="Mother Name" name="mother_name">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="text" class="form-control" id="email" placeholder="Email Address" name="email">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="birth" class="form-label">Date of Birth</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="birth" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" name="date" autocomplete="off" >
                                                    <div class="invalid-feedback"></div>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="number"  id="mobile" placeholder="+88 0" name="mobile" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Gender</label>
                                            <div class="d-flex" style="gap: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" style="padding: 7px;" required>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" style="padding: 7px;" required>
                                                    <div class="invalid-feedback"></div>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>

                                <div style="border-bottom: 1px solid #00000040;" class="my-4"></div>

                                <h5 class="mb-4">
                                    Permanent Address
                                </h5>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="pdivision" class="form-label">Division</label>
                                            <input type="text" id="pdivision"  name="pdivision">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="pdistrict" class="form-label">District</label>
                                            <input type="text"  id="pdistrict"  name="pdistrict">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="paddress" class="form-label">Address</label>
                                            <input type="text" id="paddress"  name="paddress">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <label for="sameaspermanent" class="mb-0">Same as Permanent Address:</label>
                                    <input type="checkbox"  id="sameaspermanent">
                                </div>

                                <h5 class="my-4 mb-3">
                                    Temporary Address
                                </h5>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tdivision" class="form-label">Division</label>
                                            <input type="text" id="tdivision"  name="tdivision">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tdistrict" class="form-label">District</label>
                                            <input type="text" id="tdistrict"  name="tdistrict">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="taddress" class="form-label">Address</label>
                                            <input type="text" id="taddress" name="taddress">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div style="border-bottom: 1px solid #00000040;" class="my-4"></div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="emp" class="form-label">Country</label>
                                            <select name="country_id" id="country_id" class="form-control select2" >
                                                <option value="">Select a country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>                                            
                                            <div id="countryErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="job_type_id" class="form-label">Job Type</label>
                                            <select name="job_type_id" id="job_type_id" class="form-control select2" >
                                                <option value="">Select a job type</option>
                                            </select>
                                            <div id="universityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Total Cost</label>
                                        <input type="text" name="total_cost" id="total_cost" class="form-control" >
                                        <div class="invalid-feedback"></div>
                                    </div>

                                </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Person Image</label>
                                                <div class="AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                            
                                                    <h3 class="drag mb-0">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="browseFile">Browse File</button>
                                                    <input type="file" name="image" class="picture" hidden>
                                                </div>
                                                <div class="msgError mt-2" id="imageErr"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label  class="form-label">Nid/birth certificate front-side</label>
                                                <div class="AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                            
                                                    <h3 class="drag mb-0">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="browseFile">Browse File</button>
                                                    <input type="file" name="front_image" class="picture" hidden>
                                                </div>
                                                <div class="msgError mt-2" id="frontErr"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label  class="form-label">Nid back-side image (optional)</label>
                                                <div class="AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                            
                                                    <h3 class="drag mb-0">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="browseFile">Browse File</button>
                                                    <input type="file" name="back_image" class="picture" hidden>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Passport Copy</label>
                                                <div class="AppBody">
                                                    <div class="icon">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                            
                                                    <h3 class="drag mb-0">Drag & Drop</h3>
                                                    <span>OR</span>
                                                    <button type="button" id="browseFile">Browse File</button>
                                                    <input type="file" name="passport_image" class="picture" hidden>
                                                </div>
                                                <div class="msgError mt-2" id="passportErr"></div>
                                            </div>
                                        </div>
                                    </div>

                                     {{-- gellary image --}}
                                    <div class="row" style="margin-top: 20px;">
                                        <label class="form-label">Additional Documents (SSC/ HSC Certificate, Marksheets,
                                            Medical Report, Bank Statement and others)</label>
                                        <div>
                                            <input type="file" id="images" name="images[]"
                                                accept=".pdf, .doc, .docx, .xls, .xlsx, .txt, image/*" multiple
                                                class="form-control" />
                                            <p class="form-text text-muted mt-1">You can select multiple files.</p>
                                            <div class="text-danger error mt-1"></div>

                                            <!-- Preview -->
                                            <div id="imagePreviewContainer" class="preview-wrapper mt-3 mb-4"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary" type="submit" id="addEmployee" style="width: 100% !important;margin:15px auto 0;margin-top:10px !important;font-size:17px;font-weight:600;"> Register </button>
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
        <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>

        <script>
            $(document).ready(function () {
                $('#country_id').on('change', function () {
                    var countryId = $(this).val();
        
                    if (countryId) {
                        $.ajax({
                            url: '/get-job/' + countryId,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#job_type_id').empty().append('<option value="">Select a job type</option>');
                                $.each(data, function (key, data) {
                                    $('#job_type_id').append('<option value="' + data.id + '">' + data.name + '</option>');
                                });
                            },
                            error: function () {
                                alert('Error loading data');
                            }
                        });
                    } else {
                        $('#job_type_id').empty().append('<option value="">Select a job type</option>');
                    }
                });
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
                            $("#addEmployee").prop('disabled', true).html(`
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            `);
                        },
                        success: function(response) {
                        
                            // Display SweetAlert popup
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Register successfully!',
                            });

                            setTimeout(() => {
                                window.location = ("{{ route('agent-person.index') }}");
                            }, 1000);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            // Reset Bootstrap validation state
                            form.find('.form-control').removeClass('is-invalid');
                            form.find('.invalid-feedback').html('');
                            $("#addEmployee").prop('disabled', false).html(`
                                Register
                            `);
                            
                            // Handle validation errors
                            var errors = xhr.responseJSON.errors;
                            console.log(errors)
                            $.each(errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.addClass('form-control');
                                input.next('.invalid-feedback').html(value); 

                                if (key === 'image') {
                                    $('#imageErr').html(value);
                                }

                                if (key === 'front_image') {
                                    $('#frontErr').html(value);
                                }

                                if (key === 'passport_image') {
                                    $('#passportErr').html(value);
                                }

                                if (key === 'country_id') {
                                    $('#countryErr').html(value);
                                }

                                if (key === 'job_type_id') {
                                    $('#universityErr').html(value);
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

        {{-- drag & drop --}}
        <script>
            function imgUploadAll() {
                // Select all AppBody containers
                document.querySelectorAll('.AppBody').forEach((dragArea, index) => {
                    const dragText = dragArea.querySelector('.drag');
                    const btn = dragArea.querySelector('button');
                    const input = dragArea.querySelector('input.picture');
                    let file;

                    btn.onclick = () => input.click();

                    input.addEventListener('change', function () {
                        file = this.files[0];
                        showPreview();
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
                        input.files = event.dataTransfer.files;
                        showPreview();
                    });

                    function showPreview() {
                        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                        if (file && validTypes.includes(file.type)) {
                            const reader = new FileReader();

                            reader.onload = () => {
                                const imgUrl = reader.result;
                                const img = `<img src="${imgUrl}">`;
                                const cancelBtn = `<div class="cancell">❌</div>`;

                                const imageContainer = document.createElement('div');
                                imageContainer.classList.add('image-container');
                                imageContainer.innerHTML = img + cancelBtn;

                                // Remove previous image if any
                                const existing = dragArea.querySelector('.image-container');
                                if (existing) dragArea.removeChild(existing);

                                dragArea.appendChild(imageContainer);

                                // Cancel Button Handler
                                imageContainer.querySelector('.cancell').addEventListener('click', () => {
                                    input.value = null;
                                    dragArea.classList.remove('active');
                                    dragText.innerText = "Drag & Drop";
                                    dragArea.removeChild(imageContainer);
                                });
                            };

                            reader.readAsDataURL(file);
                        } else {
                            alert('Invalid file type. Only JPG, JPEG, PNG allowed.');
                            dragArea.classList.remove('active');
                            dragText.innerText = "Drag & Drop";
                        }
                    }
                });
            }

            // Initialize
            imgUploadAll();
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const checkbox = document.getElementById("sameaspermanent");

                checkbox.addEventListener("change", function () {
                    if (this.checked) {
                        document.getElementById("tdivision").value = document.getElementById("pdivision").value;
                        document.getElementById("tdistrict").value = document.getElementById("pdistrict").value;
                        document.getElementById("taddress").value = document.getElementById("paddress").value;
                    } else {
                        document.getElementById("tdivision").value = "";
                        document.getElementById("tdistrict").value = "";
                        document.getElementById("taddress").value = "";
                    }
                });
            });
        </script>


        <script>
            document.getElementById('images').addEventListener('change', function(event) {
                const files = event.target.files;
                const previewContainer = document.getElementById('imagePreviewContainer');
                previewContainer.innerHTML = '';

                // Loop through selected files
                Array.from(files).forEach((file, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-item';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.className = 'remove-btn';

                    removeBtn.addEventListener('click', function() {
                        const dt = new DataTransfer();
                        Array.from(files).forEach((f, i) => {
                            if (i !== index) dt.items.add(f);
                        });
                        event.target.files = dt.files;
                        wrapper.remove();
                        // Re-render updated previews
                        document.getElementById('images').dispatchEvent(new Event('change'));
                    });

                    // ** Determine file type for preview **
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    const validImages = ['jpg', 'jpeg', 'png', 'gif'];
                    const validDocs = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];

                    if (validImages.includes(fileExtension)) {
                        // Image Preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            wrapper.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else if (validDocs.includes(fileExtension)) {
                        // File Preview for non-images
                        const icon = document.createElement('img');

                        if (fileExtension === 'pdf') {
                            icon.src = '/backend/icons/pdf.png';
                        } else if (['doc', 'docx'].includes(fileExtension)) {
                            icon.src = '/backend/icons/word.png';
                        } else if (['xls', 'xlsx'].includes(fileExtension)) {
                            icon.src = '/backend/icons/excel.png';
                        } else if (fileExtension === 'txt') {
                            icon.src = '/backend/icons/txt.png';
                        } else {
                            icon.src = '/backend/icons/file.png';
                        }

                        icon.className = 'file-icon';
                        wrapper.appendChild(icon);
                    }

                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                });
            });
        </script>

@endsection