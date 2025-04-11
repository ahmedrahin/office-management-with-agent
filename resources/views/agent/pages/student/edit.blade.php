@extends('agent.layout.template')
@section('page-title')
   Edit Student Register Form 
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
                                <li class="breadcrumb-item active">Edit Register Form</li>
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
                                    Edit Student
                                </div>
                                <div>
                                    <a href="{{ route('student-registration.index') }}" class="btn btn-primary addnew"> <i class="ri-arrow-left-line"></i> View All</a>
                                </div>
                            </h4>

                            <form action="{{route('student.update', $student->id)}}" method="POST" class="needs-validation"  novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="validationName" placeholder="Student Name" name="name" value="{{ $student->name }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father Name</label>
                                            <input type="text"  id="father_name" placeholder="Father Name" name="father_name" value="{{ $student->father_name }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mother_name" class="form-label">Mother Name</label>
                                            <input type="text"  id="mother_name" placeholder="Mother Name" name="mother_name" value="{{ $student->mother_name }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="text" class="form-control" id="email" placeholder="Email Address" name="email" value="{{ $student->email }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="birth" class="form-label">Date of Birth</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="birth" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" name="date" autocomplete="off" value="{{ $student->date_of_birth }}">
                                                    <div class="invalid-feedback"></div>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="number"  id="mobile" placeholder="+88 0" name="mobile" value="{{ $student->mobile }}" required>
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
                                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" style="padding: 7px;" {{ $student->gender == 'male' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" style="padding: 7px;" {{ $student->gender == 'female' ? 'checked' : '' }} required>
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
                                            <input type="text" id="pdivision"  name="pdivision" value="{{ $student->permanent_division }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="pdistrict" class="form-label">District</label>
                                            <input type="text"  id="pdistrict"  name="pdistrict" value="{{ $student->permanent_district }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="paddress" class="form-label">Address</label>
                                            <input type="text" id="paddress"  name="paddress" value="{{ $student->permanent_address }}">
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
                                            <input type="text" id="tdivision"  name="tdivision" value="{{ $student->temporary_division }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tdistrict" class="form-label">District</label>
                                            <input type="text" id="tdistrict"  name="tdistrict" value="{{ $student->temporary_district }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="taddress" class="form-label">Address</label>
                                            <input type="text" id="taddress" name="taddress"  value="{{ $student->temporary_address }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div style="border-bottom: 1px solid #00000040;" class="my-4"></div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="emp" class="form-label">Country</label>
                                            <select name="country_id" id="country_id" class="form-control select2" required>
                                                <option value="">Select a country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $student->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>                                            
                                            <div id="countryErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="university_id" class="form-label">University</label>
                                            <select name="university_id" id="university_id" class="form-control select2" required>
                                                <option value="">Select a university</option>
                                            </select>
                                            <div id="universityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control select2" required>
                                            <option value="">Select a subject</option>
                                        </select>
                                    </div>
                                
                                    {{-- Price --}}
                                    <div class="col-md-3">
                                        <label class="form-label">Processing Fees</label>
                                        <input type="text" name="processing_fees" id="subject_price" class="form-control" readonly>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Total Cost</label>
                                        <input type="text" name="total_cost" id="total_cost" class="form-control" value="{{ $student->total_cost }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                </div>

                                <div class="row">
                                    @php
                                        $images = [
                                            'image' => 'Student Image',
                                            'front_image' => 'Front Image',
                                            'back_image' => 'Back Image',
                                            'passport_image' => 'Passport Image',
                                        ];
                                    @endphp
                                
                                    @foreach ($images as $field => $label)
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">{{ $label }}</label>
                                            <div class="AppBody" data-name="{{ $field }}">
                                                <div class="icon"><i class="fas fa-images"></i></div>
                                                <h3 class="drag">Drag & Drop</h3>
                                                <span>OR</span>
                                                <button type="button" class="browseFile">Browse File</button>
                                                <input type="file" name="{{ $field }}" class="picture" hidden>
                                
                                                {{-- Show existing image if available --}}
                                                @if (!is_null($student->$field))
                                                    <img src="{{ asset($student->$field) }}" alt="" id="editImg-{{ $field }}">
                                                    <div class="cancell" id="editCan-{{ $field }}">❌</div>
                                                @endif
                                            </div>
                                            <div class="msgError mt-2" id="{{ $field }}Err"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                

                                <div>
                                    <button class="btn btn-primary" type="submit" id="addEmployee" style="width: 100% !important;margin:15px auto 0;margin-top:10px !important;"> Save Changes </button>
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
            // Define selected values from Blade/PHP
            var selectedCountryId = "{{ $student->country_id }}";
            var selectedUniversityId = "{{ $student->university_id }}";
            var selectedSubjectId = "{{ $student->subject_id }}";
    
            // Country change: Load universities
            $('#country_id').on('change', function () {
                var countryId = $(this).val();
    
                if (countryId) {
                    $.ajax({
                        url: '/get-university/' + countryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#university_id').empty().append('<option value="">Select a university</option>');
                            $.each(data, function (key, university) {
                                var selected = (university.id == selectedUniversityId) ? 'selected' : '';
                                $('#university_id').append('<option value="' + university.id + '" ' + selected + '>' + university.name + '</option>');
                            });
    
                            // Trigger change to load subjects if editing
                            if (selectedUniversityId) {
                                $('#university_id').trigger('change');
                            }
                        },
                        error: function () {
                            alert('Error loading universities');
                        }
                    });
                } else {
                    $('#university_id').empty().append('<option value="">Select a university</option>');
                }
            });
    
            // University change: Load subjects
            $('#university_id').on('change', function () {
                let universityId = $(this).val();
                $('#subject_id').empty().append('<option value="">Loading...</option>');
                $('#subject_price').val('');
    
                if (universityId) {
                    $.get('/get-subject/' + universityId, function (data) {
                        $('#subject_id').empty().append('<option value="">Select a subject</option>');
                        $.each(data, function (index, subject) {
                            var selected = (subject.id == selectedSubjectId) ? 'selected' : '';
                            $('#subject_id').append('<option value="' + subject.id + '" data-price="' + subject.price + '" ' + selected + '>' + subject.name + '</option>');
                        });
    
                        // If editing, set price of selected subject
                        if (selectedSubjectId) {
                            let selectedOption = $('#subject_id').find('option:selected');
                            let selectedPrice = selectedOption.data('price') || '';
                            $('#subject_price').val(selectedPrice);
                        }
                    });
                } else {
                    $('#subject_id').empty().append('<option value="">Select a subject</option>');
                }
            });
    
            // Subject change: Show price
            $('#subject_id').on('change', function () {
                let selectedPrice = $(this).find(':selected').data('price') || '';
                $('#subject_price').val(selectedPrice);
            });
    
            // ======== On Page Load (Edit Page) =========
            if (selectedCountryId) {
                $('#country_id').val(selectedCountryId).trigger('change');
            }
        });
    </script>
    

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
                      
                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Update successfully!',
                        });

                        setTimeout(() => {
                            window.location = ("{{ route('student.index') }}");
                        }, 1000);
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

                            if (key === 'image') {
                                $('#imageErr').html(value);
                            }

                            if (key === 'front_image') {
                                $('#front_imageErr').html(value);
                            }

                            if (key === 'passport_image') {
                                $('#passport_imageErr').html(value);
                            }

                            if (key === 'country_id') {
                                $('#countryErr').html(value);
                            }

                            if (key === 'university_id') {
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
        function imgUpload(dragArea) {
            let dragText = dragArea.querySelector('.drag');
            let btn = dragArea.querySelector('.browseFile');
            let input = dragArea.querySelector('.picture');
            let fieldName = dragArea.dataset.name;
            let file;
    
            btn.onclick = () => {
                input.click();
            }
    
            input.addEventListener('change', function () {
                file = this.files[0];
                show();
            })
    
            dragArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dragText.innerText = "Release to Upload File";
                dragArea.classList.add('active');
            })
    
            dragArea.addEventListener('dragleave', (event) => {
                dragText.innerText = "Drag & Drop";
                dragArea.classList.remove('active');
            })
    
            dragArea.addEventListener('drop', (event) => {
                event.preventDefault();
                file = event.dataTransfer.files[0];
                input.files = event.dataTransfer.files;
                show();
            })
    
            function show() {
                let fileType = file.type;
                let validType = ['image/jpeg', 'image/jpg', 'image/png'];
    
                if (validType.includes(fileType)) {
                    let fileRead = new FileReader();
                    fileRead.onload = () => {
                        let imgUrl = fileRead.result;
                        let img = `<img src="${imgUrl}" id="preview-${fieldName}">`;
                        let cancelButton = `<div class="cancell" id="cancel-${fieldName}">❌</div>`;
                        let container = document.createElement('div');
                        container.classList.add('image-container');
                        container.innerHTML = img + cancelButton;
    
                        let existing = dragArea.querySelector('.image-container');
                        if (existing) dragArea.removeChild(existing);
                        dragArea.appendChild(container);
    
                        dragText.innerText = "Drag & Drop";
    
                        document.getElementById(`cancel-${fieldName}`).addEventListener('click', function () {
                            input.value = '';
                            dragArea.classList.remove('active');
                            dragText.innerText = "Drag & Drop";
                            dragArea.removeChild(container);
                        });
                    }
                    fileRead.readAsDataURL(file);
                } else {
                    alert('Invalid file type');
                    dragText.innerText = "Drag & Drop";
                    dragArea.classList.remove('active');
                }
            }
    
            // If edit image exists, allow cancelling it
            let existingCancel = document.getElementById(`editCan-${fieldName}`);
            let existingImg = document.getElementById(`editImg-${fieldName}`);
            if (existingCancel && existingImg) {
                existingCancel.addEventListener('click', function () {
                    existingImg.remove();
                    existingCancel.remove();
                });
            }
        }
    
        // Initialize all drag areas
        document.querySelectorAll('.AppBody').forEach(imgUpload);
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


@endsection