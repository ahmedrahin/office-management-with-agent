@extends('backend.layout.template')
@section('page-title')
    <title>Paid Salary List || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
    <style>
        .disabled {
            pointer-events: none; 
            opacity: 0.4 !important; 
            cursor: default;
        }
        .monthlyExpense .btn-primary, .monthlyExpense .btn-success {
            margin-bottom: 9px;
            margin-left: 5px;
        }
        input[type="radio"]{
            padding: 0 !important;
        }
        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table label i {
            padding-left: 6px;
        }
        
        table label {
            display: flex;
            align-items: center;
        }
        .ri-checkbox-circle-line {
            color: #03c003;
            padding-left: 12px;
        }
        .ri-close-circle-line {
            color: #ff0000ba;
        }
        
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title span {
            font-weight: 800;
            font-size: 16px;
        }
        td label {
            display: inline;
            float: right;
            padding-right: 50px;
        }
    </style>
@endsection

@section('body-content')
@php
use Carbon\Carbon;
@endphp
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Paid Salary List</li>
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
                            <h4 class="card-title">
                                Employee Salary List
                                <span class="text-danger">
                                    {{date('M-Y')}}
                                </span>
                            </h4>
                            @if( $employees->count() == 0 )
                                <div class="alert alert-danger" role="alert">
                                    No Data Found!
                                </div>
                            @else
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Absence</th>
                                            <th>Salary</th>
                                            <th>Adv. Salary</th>
                                            <th>Paid</th>
                                            <th>Issue Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $counter = 1; 
                                        @endphp
                                        @foreach ($employees as $employee)
                                            @php
                                                $employee_join_date = Carbon::createFromFormat('j M, Y', $employee->join_date)->format('M Y');

                                                $selected_date = Carbon::parse($month . ' ' . $year)->format('M Y');
                                                // echo $employee_join_date  . '  ' . '<span class="text-danger">' . $selected_date . '</span>' . '<br>';
                                                
                                                $advance = App\Models\AdvanceSalary::where('employees_id', $employee->id)->where('salary_month', $month)->where('salary_year', $year)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$counter++}}</td>
                                                <td class="center">
                                                    @if( !is_null($employee->image) )
                                                        <img src="{{asset($employee->image)}}" alt="" class="user-img">
                                                    @else
                                                        <img src="{{asset('backend/images/user.jpg')}}" alt="" class="user-img">
                                                    @endif
                                                </td>
                                               
                                                <td>
                                                    {{$employee->name}}
                                                    <br>
                                                    <span class="badge bg-primary">{{ $employee->employee_office_id }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if( $employee->absences > 0 )
                                                        <span class="badge bg-danger">{{ $employee->absences }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ $employee->absences }}</span>
                                                    @endif
                                                </td>

                                                {{-- @if( !($employee_join_date < $selected_date) ) --}}
                                                    <td>
                                                        ৳{{ $employee->basic_salary }}
                                                    </td>

                                                    <td class="text-center">
                                                        @if( $advance )
                                                            <span class="badge bg-success">+ {{ $advance->adv_salary }}tk</span>
                                                        @else
                                                            <i class="no">N/A</i>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if( $employee->salary !== null )
                                                            ৳{{ $employee->salary }}
                                                            
                                                        @else
                                                            ৳0
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($employee->salary_issue_date)
                                                            {{ Carbon::parse($employee->salary_issue_date)->format('j M Y') }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if($employee->salary !== null)
                                                            @if( $employee->due )
                                                                <span class="badge bg-info">Due</span>
                                                            @else
                                                                <span class="badge bg-success">Paid</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-danger">Unpaid</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if( $employee->salary !== null )
                                                            <a href="{{ route('pay.details', [$employee->id, request('year', date('Y')), request('month', date('m'))]) }}" 
                                                                class="btn btn-primary" target="_blank" style="padding-bottom: 1px !important;padding: 3px 8px;">
                                                                Details
                                                            </a>   
                                                        @else
                                                            <a href="{{ route('pay.salary', [$employee->id, request('year', date('Y')), request('month', date('m'))]) }}" 
                                                                class="btn btn-info" 
                                                                style="padding-bottom: 1px !important;padding: 3px 8px;">
                                                                Pay
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td class="action">
                                                        @if( $employee->salary !== null )
                                                            <button>
                                                                <a href="">
                                                                    <i class="ri-edit-2-fill"></i>
                                                                </a>
                                                            </button>
                                                            <button class="deleteButton" data-id="{{ $employee->salary_id }}">
                                                                <i class="ri-delete-bin-2-fill"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                {{-- @else
                                                    <td class="text-center" colspan="8"><span class="badge bg-warning">No Join Yet</span></td>
                                                @endif --}}
                                                
                                            </tr>
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- end card -->
                </div> 
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            Show All Months ({{ request('year', date('Y')) }}) Salary Report
                        </div>
                
                        <div class="card-body">
                            <div class="row monthlyExpense">
                                <div class="col-12">
                                    @php
                                        $currentMonth = date('n'); 
                                        $selectedYear = request('year', date('Y')); 
                                        $currentYear = date('Y');
                                    @endphp
                                    
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $monthName = \Carbon\Carbon::create($selectedYear, $i, 1)->format('M');
                                            $disabled = ($selectedYear == $currentYear && $i > $currentMonth) ? 'disabled' : ''; 
                                            $buttonClass = (strtolower(request('month')) == strtolower($monthName)) ? 'btn-success' : 'btn-primary';
                                            $isCurrentMonth = (strtolower(date('M')) == strtolower($monthName) && request('month') == null) ? 'btn-success' : '';
                                        @endphp
                
                                        <a href="{{ route('pay.list', ['month' => strtolower($monthName), 'year' => $selectedYear]) }}" 
                                        class="btn {{ $buttonClass }} {{ $isCurrentMonth }} {{ $disabled }}">
                                            {{ $monthName }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <strong>Select Year</strong>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($allYear as $availableYear)
                                    <a href="{{ route('pay.list', ['year' => $availableYear, 'month' => (Carbon::now()->format('M'))]) }}" 
                                    class="btn btn-primary mb-2 {{ request('year') == $availableYear ? 'btn-success text-white' : '' }}"
                                    style="width: 45%; text-align: center;">
                                        {{ $availableYear }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div> 
    </div>
    <!-- End Page-content -->
                
@endsection

@section('page-script')
    <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
        $('#salaryTable').DataTable({
            dom: 'Bfrtip', // Enables buttons
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Employee Salary List',
                    exportOptions: {
                        columns: ':not(:last-child)', // Excludes the last column
                        columns: [0,1,2,3,4,5,6] // Specify which columns to include (adjust indexes as needed)
                    },
                    orientation: 'landscape', // Adjusts layout
                    pageSize: 'A4' // Paper size
                }
            ],
            "columnDefs": [
                { "orderable": false, "targets": [8,9] } // Disables sorting for "Details" and "Action" columns
            ]
        });
    });

    </script>
    
    <script>
         $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                
                var id = deleteButton.data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this employee data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("delete.salary", ":id") }}'.replace(':id', id),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                Swal.fire('Deleted!', 'Salary has been deleted.', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete employee.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        @endif
    </script>

    <!-- Responsive examples -->
    <script src="{{asset('backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{asset('backend/js/pages/datatables.init.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{asset('backend/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('backend/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

    <script src="{{asset('backend/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>

@endsection
