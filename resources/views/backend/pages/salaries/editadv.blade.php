@extends('backend.layout.template')

@section('page-title')
    <title>Pay Advance Salary || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        .card-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: #343a40;
        }
        .salary-details-table th, .salary-details-table td {
            padding: 10px;
            text-align: left;
        }
        .pay-now-btn {
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
        }
        .form-label {
            font-weight: 600;
            font-size: 15px;
        }
        
    </style>
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/libs/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('body-content')

    <div class="page-content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Pay Advance Salary</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Payment Form -->
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Pay Advance Salary</h4>

                            <form action="{{ route('updateadv.salary',$data->id) }}" method="POST" class="needs-validation mt-2" novalidate>
                                @csrf

                                <div class="row">
                                    <input name="employees_id" value="{{ request('id') }}" hidden>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="employees_id" class="form-label">Employee</label>
                                            <input type="text" value="{{ $data->employees->name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="salary" class="form-label">Salary Amount</label>
                                            <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ $data->adv_salary }}">
                                            @error('salary')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Select a month</label>
                                            <div class="input-group" id="datepicker4">
                                                <input type="text" class="form-control @error('date') is-invalid @enderror"
                                                    placeholder="MM yyyy"
                                                    data-date-format="MM yyyy"
                                                    data-date-min-view-mode="1"
                                                    data-date-container='#datepicker4'
                                                    data-provide="datepicker"
                                                    name="date"
                                                    autocomplete="off"
                                                    value="{{ $data->salary_date }}"
                                                    >
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            @error('date')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                
                                </div>
                                
                                <div class="mb-3">
                                    <label for="details" class="form-label">Write Details</label>
                                    <textarea id="elm1" class="form-control" placeholder="Write Details.." name="details" rows="5">{{ $data->description }}</textarea>
                                </div>

                                <button class="btn btn-primary pay-now-btn" type="submit" id="addExpense">
                                     Save Changes
                                </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection



@section('page-script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    {{-- <script>
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
    </script> --}}

    

    <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>

     {{-- data picker --}}
     <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
     {{-- select box --}}
     <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
     <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
    
   
@endsection