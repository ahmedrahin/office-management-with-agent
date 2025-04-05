@extends('backend.layout.template')
@section('page-title')
    <title>Pay Salary || {{ \App\Models\Settings::site_title() }}</title>
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
                                <li class="breadcrumb-item active">Pay Salary</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Pay Salary</h4>

                            <form action="{{ route('paid.salary') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <!-- Employee Selection -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="employees_id" class="form-label">Select an Employee</label>
                                            <select name="employees_id" class="form-control select2 @error('employees_id') is-invalid @enderror" id="employees_id">
                                                <option value="">Select an Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('employees_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} - {{ $employee->employee_office_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employees_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="salary_note" class="form-label">Salary Cut Reasone</label>
                                            <select name="salary_note" id="salary_note">
                                                <option value="" selected>Full Payment</option>
                                                <option value="absence">For Absence</option>
                                                <option value="fine">Fine</option>
                                            </select>
                                        </div>
                                    </div>
                            
                                    <!-- Salary Amount -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="salary" class="form-label">Salary Amount</label>
                                            <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary') }}">
                                            @error('salary')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Paid Date -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Salary Month</label>
                                            <div class="input-group" id="datepicker4">
                                                <input type="text" class="form-control @error('date') is-invalid @enderror"
                                                    placeholder="MM yyyy"
                                                    data-date-format="MM yyyy"
                                                    data-date-min-view-mode="1"
                                                    data-date-container='#datepicker4'
                                                    data-provide="datepicker"
                                                    name="date"
                                                    autocomplete="off"
                                                    value="{{ old('date') }}"
                                                    >
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            @error('date')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="due" class="form-label">Due Amount</label>
                                            <input type="number" name="due" id="due">
                                            @error('due')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
    

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bonus" class="form-label">Bonus (optional)</label>
                                            <input type="text" name="bonus" id="bonus">
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Details -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="details" class="form-label">Write Details</label>
                                            <textarea id="elm1" class="form-control" placeholder="Write Details.." name="details" rows="5">{{ old('details') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div>
                                    <button class="btn btn-primary" type="submit" id="addExpense">Pay Now</button>
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
         $(document).ready(function() {
            $('#employees_id').change(function() {
                var employeeId = $(this).val();

                if (employeeId) {
                    $.ajax({
                        url: '/get-pay-employee/' + employeeId,
                        type: 'GET',
                        success: function(response) {
                            if (response) {
                                $('#salary').val(response.salary);
                            } else {
                                $('#salary').val('');
                            }
                        },
                        error: function() {
                            alert('Error fetching employee details');
                        }
                    });
                } else {
                    $('#salary').val('');
                }
            });
        });
    </script>

   

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'View Pay List'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('pay.list') }}";
                }
            });
        @endif
    </script>

    <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>

     {{-- data picker --}}
     <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
     {{-- select box --}}
     <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
     <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
    
   
@endsection