@extends('backend.layout.template')
@section('page-title')
    <title>Add Income || {{ \App\Models\Settings::site_title() }}</title>
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
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Add Income</li>
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
                            <h4 class="card-title">Add New Income</h4>

                            <form action="{{route('store.income')}}" method="POST" class="needs-validation"  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Income Title</label>
                                            <input type="text" class="form-control" id="name" placeholder="title..." name="name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="amn" class="form-label">Income Amount</label>
                                            <input type="text" class="form-control" id="amn" placeholder=" Amount" name="amn" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="month" class="form-label">Month</label>
                                            <select name="month" class="form-control select2" id="month" required>
                                                
                                                <option value="1" {{(date('n') == 1) ? "selected" : ''}}>January</option>
                                                <option value="2" {{(date('n') == 2) ? "selected" : ''}}>February</option>
                                                <option value="3" {{(date('n') == 3) ? "selected" : ''}}>March</option>
                                                <option value="4" {{(date('n') == 4) ? "selected" : ''}}>April</option>
                                                <option value="5" {{(date('n') == 5) ? "selected" : ''}}>May</option>
                                                <option value="6" {{(date('n') == 6) ? "selected" : ''}}>June</option>
                                                <option value="7" {{(date('n') == 7) ? "selected" : ''}}>July</option>
                                                <option value="8" {{(date('n') == 8) ? "selected" : ''}}>August</option>
                                                <option value="9" {{(date('n') == 9) ? "selected" : ''}}>September</option>
                                                <option value="10" {{(date('n') == 10) ? "selected" : ''}}>October</option>
                                                <option value="11" {{(date('n') == 11) ? "selected" : ''}}>November</option>
                                                <option value="12" {{(date('n') == 12) ? "selected" : ''}}>December</option>
                                            </select>
                                            <div id="month_error" class="err"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="year" class="form-label">Year</label>
                                            <input type="text" class="form-control" id="year" placeholder="Year" name="year" value="{{date('Y')}}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Income Date (optional)</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" name="date" autocomplete="off" >
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <div id="e_date_error" class="err"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="vo" class="form-label">Write Details</label>
                                            <textarea id="elm1" placeholder="Write Details.." name="details"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                            <label for="salary" class="form-label">Memo Picture</label>
                                            <div class="AppBody">
                                                <div class="icon">
                                                    <i class="fas fa-images"></i>
                                                </div>
                                        
                                                <h3 class="drag">Drag & Drop</h3>
                                                <span>OR</span>
                                                <button type="button" id="browseFile">Browse File</button>
                                                <input type="file" name="image" class="picture" hidden>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <button class="btn btn-primary" type="submit" id="addExpense"> Add Income </button>
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

     {{-- data picker --}}
     <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
     {{-- select box --}}
     <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
     <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
    {{-- form editor --}}
    <script src="{{asset('backend/js/pages/form-editor.init.js')}}"></script>
    <script src="{{asset('backend/libs/tinymce/tinymce.min.js')}}"></script>
     {{-- send expencs data --}}
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
                             Add Income
                         `);
                         $('.needs-validation')[0].reset();
                         $('.needs-validation').find('.form-control').removeClass('form-control');
                         $('#datepicker1').addClass('boxIcon');
                         $('#datepicker1 .input-group-text').addClass('dateIcon');
                         $('#month_error').html('');
                         $('#e_date_error').html('');

                         // Display SweetAlert popup
                         Swal.fire({
                             icon: 'success',
                             title: 'Success!',
                             text: 'Add Income successfully!',
                         });

                         setTimeout(() => {
                            window.location = ("{{ route('manage.income') }}");
                        }, 1000);
                     },
                     error: function(xhr, textStatus, errorThrown) {
                        // Reset Bootstrap validation state
                        form.find('.form-control').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');
                        $("#addExpense").prop('disabled', false).html(' Add Income');
                        
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        console.log(errors);
                        $.each(errors, function(key, value) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.addClass('form-control');
                            if (key === 'month') {
                                $('#month_error').html(value);
                            }else if (key === 'date') {
                                $('#e_date_error').html(value);
                            } else {
                                input.next('.invalid-feedback').html(value);
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
        function imgUpload() {
            let dragArea = document.querySelector('.AppBody');
            let dragText = document.querySelector('.drag');
            let btn = document.querySelector('#browseFile');
            let input = document.querySelector('.picture');
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
                input.files = event.dataTransfer.files; // Set files to input
                show();
            })

            function show() {
                let fileType = file.type;
                let validType = ['image/jpeg', 'image/jpg', 'image/png'];

                if (validType.includes(fileType)) {
                    let fileRead = new FileReader();
                    fileRead.onload = () => {
                        let imgUrl = fileRead.result;
                        let img = `<img src="${imgUrl}">`;
                        let cancelButton = `<div class="cancell">
                                                ❌
                                            </div>`;
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

                        // Add event listener to the cancel button
                        let cancelButtonElement = imageContainer.querySelector('.cancell');
                        cancelButtonElement.addEventListener('click', function () {
                            // Clear the input file and remove the image container
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

        imgUpload();
    </script>

@endsection