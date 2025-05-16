@extends('agent.layout.template')

@section('page-title')
    Profile
@endsection

@section('page-css')
    {{-- custom --}}
    <style>
        .card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        h5 {
            font-size: 16px !important;
            font-weight: 800 !important;
        }

        .customer th {
            background: #252b3be6;
            color: white;
        }

        .p_d {
            background: #252b3be6 !important;
            color: white;
        }

        .customer {
            background: #f7f6f6;
        }

        .btn-danger {
            padding: 1px 5px;
            font-size: 11px;
            font-weight: 800;
        }

        .card-body.status {
            border: 1px solid #e4e5e6;
            border-top: 0;
        }

        .img-box {
            width: 150px;
            height: 150px;
            margin: auto;
            margin-bottom: 40px;
            border: 4px solid #0d85cf;
            border-radius: 50%;
            position: relative;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        #saveChange {
            margin-top: 15px;
        }

        #saveChange:focus {
            box-shadow: none !important;
        }

        .img-box input {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
            opacity: 0;
            z-index: 11;
        }

        .img-box i {
            position: absolute;
            bottom: 10px;
            right: 3px;
            background: black;
            width: 32px;
            height: 32px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .ri-delete-bin-7-fill {
            visibility: hidden;
            z-index: 111;
            cursor: pointer;
        }

        .needs-validationP {
            margin-top: 40px;
        }

        .needs-validationP h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hasRemove {
            visibility: visible;
        }
    </style>
@endsection

@section('body-content')
    <!-- start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Your Profile</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="margin-bottom: 20px;">

                            <h4 class="card-title">
                                Edit Your Profile
                            </h4>

                            <form action="{{ route('update.info', auth()->user()->id) }}" method="post"
                                class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-10 offset-md-1">

                                        <!-- Image Section -->
                                        <div class="user-pic">
                                            @if (!is_null(Auth::user()->image))
                                                <div class="img-box">
                                                    <img src="{{ asset(Auth::user()->image) }}" alt=""
                                                        id="upImg">
                                                    <input type="file" name="image" class="upImg">
                                                    <i class="ri-delete-bin-7-fill hasRemove"></i>
                                                    <input type="hidden" name="hasRemove" id="hasRemove">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                            @else
                                                <div class="img-box">
                                                    <img src="{{ asset('backend/images/user.jpg') }}" alt=""
                                                        id="upImg">
                                                    <input type="file" name="image" class="upImg">
                                                    <input type="hidden" name="hasRemove" id="hasRemove">
                                                    <i class="fas fa-camera"></i>
                                                    <i class="ri-delete-bin-7-fill"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Basic Info -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name">Your Name</label>
                                                    <input type="text" id="name" name="name"
                                                        placeholder="Your Name" required value="{{ Auth::user()->name }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email">Your Email</label>
                                                    <input type="email" id="email" name="email"
                                                        placeholder="Your Email" required value="{{ Auth::user()->email }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Personal Info -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="father_name">Father's Name</label>
                                                <input type="text" id="father_name" name="father_name"
                                                    placeholder="Father's Name" value="{{ Auth::user()->father_name }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mother_name">Mother's Name</label>
                                                <input type="text" id="mother_name" name="mother_name"
                                                    placeholder="Mother's Name" value="{{ Auth::user()->mother_name }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="wife_name">Wife's Name</label>
                                                <input type="text" id="wife_name" name="wife_name"
                                                    placeholder="Wife's Name" value="{{ Auth::user()->wife_name }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Address Info -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="division">Division</label>
                                                <input type="text" id="division" name="division" placeholder="Division"
                                                    value="{{ Auth::user()->division }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="district">District</label>
                                                <input type="text" id="district" name="district"
                                                    placeholder="District" value="{{ Auth::user()->district }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="sub_district">Sub District</label>
                                                <input type="text" id="sub_district" name="sub_district"
                                                    placeholder="Sub District" value="{{ Auth::user()->sub_district }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ward_no">Ward No</label>
                                                <input type="text" id="ward_no" name="ward_no"
                                                    placeholder="Ward No" value="{{ Auth::user()->ward_no }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="village">Village</label>
                                                <input type="text" id="village" name="village"
                                                    placeholder="Village" value="{{ Auth::user()->village }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Experience Info -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Previous Experience as Agent?</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input p-0" type="radio" name="previous_experience" id="experience_yes" value="yes">
                                                        <label class="form-check-label" for="experience_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input p-0" type="radio" name="previous_experience" id="experience_no" value="no" checked>
                                                        <label class="form-check-label" for="experience_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="experience_years">Experience Years</label>
                                                <input type="number" id="experience_years" name="experience_years"
                                                    placeholder="Experience Years"
                                                    value="{{ Auth::user()->experience_years }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="study_institute" class="form-label">Institute /
                                                        Study</label>
                                                    <textarea id="" placeholder="Institute and Study Details" name="study_institute" class="editor">{{ Auth::user()->study_institute }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="vo" class="form-label">Institutes Name
                                                        (Minimum:5)</label>
                                                    <textarea id="" placeholder="Write Here.." name="details" class="editor">{{ Auth::user()->institute_name }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button class="btn btn-primary mt-3" type="submit" id="saveChange">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </form>


                            <form action="{{ route('update.passoword', auth()->user()->id) }}" method="post"
                                class="needs-validationP" novalidate>
                                @csrf

                                <div class="row">
                                    <div class="col-md-10 offset-md-1">
                                        <h2>Change your password</h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="update_password_current_password">Current Password</label>
                                                    <input type="password" class="form-control"
                                                        id="update_password_current_password" name="current_password"
                                                        placeholder="******" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="update_password_password">New Password *</label>
                                                    <input type="password" class="form-control"
                                                        id="update_password_password" name="password"
                                                        placeholder="******" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="update_password_password_confirmation">Confirm Password
                                                        *</label>
                                                    <input type="password" class="form-control"
                                                        id="update_password_password_confirmation"
                                                        name="password_confirmation" placeholder="******" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" id="changePass">Change
                                            Password</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
    </div>
    <!-- End Page-content -->
@endsection


@section('page-script')
    <script src="{{ asset('backend/js/pages/form-editor.init.js') }}"></script>
    <script src="{{ asset('backend/libs/tinymce/tinymce.min.js') }}"></script>

    {{-- change admin info --}}
    <script>
        $(document).ready(function() {

            // image upload
            function imageUpload() {
                const $img = $("#upImg");
                const $inputBox = $(".upImg");
                const $deleteBtn = $(".ri-delete-bin-7-fill");
                const $cameraIcon = $(".fa-camera");
                const $hasRemoveInput = $("#hasRemove");

                $inputBox.on("change", function() {
                    const file = this.files[0];
                    if (file) {
                        $img.attr("src", URL.createObjectURL(file));
                        $cameraIcon.css("visibility", "hidden");
                        $deleteBtn.css("visibility", "visible");
                        $hasRemoveInput.val('');
                    }
                });

                $deleteBtn.on("click", function() {
                    $(this).css("visibility", "hidden");
                    $cameraIcon.css("visibility", "visible");
                    $inputBox.val(null);
                    $img.attr("src", "{{ asset('backend/images/user.jpg') }}");
                    $hasRemoveInput.val('1');
                    $('#saveChange').prop('disabled', false);
                });
            }
            imageUpload()

            $('#saveChange').prop('disabled', true);

            // Enable the submit button when any input field changes
            $('.needs-validation input').on('input', function() {
                $('#saveChange').prop('disabled', false);
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
                    beforeSend: function() {
                        $("#saveChange").prop('disabled', true).html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    `);
                    },
                    success: function(response) {
                        $("#saveChange").prop('disabled', true).html(`
                        Save Changes
                    `);
                        $('.needs-validation').find('.form-control').removeClass(
                            'form-control');
                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Information Updated',
                        });
                        $('.user-pic').html(response.html);
                        imageUpload()
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#saveChange").prop('disabled', false).html('Save Changes');

                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        console.log(errors);
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

            // change password
            $('#changePass').prop('disabled', true);

            // Enable the submit button when any input field changes
            $('.needs-validationP input').on('input', function() {
                $('#changePass').prop('disabled', false);
            });
            $('.needs-validationP').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    contentType: false, // Don't set content type
                    processData: false, // Don't process the data
                    beforeSend: function() {
                        $("#changePass").prop('disabled', true).html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    `);
                    },
                    success: function(response) {
                        $("#changePass").prop('disabled', true).html(`
                        Change Password
                    `);
                        $('.needs-validation').find('.form-control').removeClass(
                            'form-control');
                        $('.needs-validationP')[0].reset();
                        // Display SweetAlert popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Your password is updated',
                        });
                        imageUpload()
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#changePass").prop('disabled', false).html('Change Password');

                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        console.log(errors);
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
            $('.needs-validationP input').on('input', function() {
                var input = $(this);
                input.removeClass('is-invalid');
                input.next('.invalid-feedback').html('');
            });
        });
    </script>
@endsection
