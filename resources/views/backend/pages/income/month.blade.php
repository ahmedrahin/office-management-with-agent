@extends('backend.layout.template')
@section('page-title')
    <title>Month income || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    {{-- custom --}}
    <style>
        .exp_info {
            height: 435px;
        }
        td p {
            margin: 0 !important;
        }
        .card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-group {
            padding: 0 !important;
        }
        a:focus {
            box-shadow: none !important;
        }
        blockquote h4{
            font-size: 13px;
            font-weight: 700;
        }
        .disabled {
            pointer-events: none; 
            opacity: 0.4 !important; 
            cursor: default;
        }
        .monthlyExpense .btn-primary, .monthlyExpense .btn-success {
            margin-bottom: 9px;
            margin-left: 5px;
        }
    </style>
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
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
                                <li class="breadcrumb-item active">Month Incomes</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">
                                
                                @if( Request::is('admin/income/month') )
                                    This Month Incomes
                                @else
                                    {{$getMonth}} Month Expenses
                                @endif

                                <span class="text-danger">
                                    @if( Request::is('admin/income/month') )
                                        ({{date('M-y')}})
                                    @else
                                       ({{$getMonth}}) 
                                    @endif
                                </span>
                                <div class="btn btn-group">
                                    <a href="{{route('manage.income')}}" class="btn btn-primary" >All</a>
                                    <a href="{{route('today.income')}}" class="btn btn-primary" >Today</a>
                                    <a href="{{route('month.income')}}" class="btn btn-primary" style="background: #0c7dc2;">This Month</a>
                                    <a href="{{route('year.income')}}" class="btn btn-primary">This Year</a>
                                </div>
                            </h4>
                            <div class="data">
                                @if( $expenses->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Income Title</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Added by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1;
                                                $months = [
                                                    1 => 'January',
                                                    2 => 'February',
                                                    3 => 'March',
                                                    4 => 'April',
                                                    5 => 'May',
                                                    6 => 'June',
                                                    7 => 'July',
                                                    8 => 'August',
                                                    9 => 'September',
                                                    10 => 'October',
                                                    11 => 'November',
                                                    12 => 'December',
                                                ];
                                            @endphp
                                            @foreach ($expenses as $expense)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{ $expense->name }}</td>
                                                    <td>{{$expense->amn}}</td>
                                                    <td>{{$expense->date}}</td>

                                                    <td class="text-center"><span class="badge bg-dark">{{ optional($expense->user)->name ?? 'N/A' }}
                                                    </span></td>
                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('show.income',$expense->id)}}" target="_blank">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                        <button>
                                                            <a href="{{route('edit.income',$expense->id)}}">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        </button>
                                                        <button class="deleteButton" data-expense-id="{{ $expense->id }}">
                                                            <i class="ri-delete-bin-2-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

            <div class="row exp_info">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            This Month All Incomes Cost
                        </div>
                        <div class="card-body">
                            <blockquote class="card-blockquote mb-0">
                                <h4>Total Incomes:
                                    <span class="text-danger" style="float: right;">
                                        @php
                                            $totalExpense = $expenses->count();
                                            echo $totalExpense;
                                        @endphp
                                    </span>
                                </h4>
                                <hr>
                                <h4>Total Incomes Amount:
                                    <span class="text-danger" style="float: right;">
                                        @php
                                            $expensesCost = $expenses->sum('amn');
                                            echo $expensesCost . "tk";
                                        @endphp
                                    </span>
                                </h4>
                            </blockquote>
                        </div>
                    </div>
                </div>
                {{-- filter others month data --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            Show Others Month's ({{$year}}) Incomes
                        </div>

                        <div class="card-body">
                            <div class="row monthlyExpense">
                                <div class="col-12">
                                    @php
                                        $currentMonth = date('n'); 
                                    @endphp
                                    
                                    @for($i = 1; $i <= 12; $i++)
                                        <?php 
                                            $monthName     = \Carbon\Carbon::create(null, $i, 1)->format('M');
                                            $disabled      = ($i > $currentMonth) ? 'disabled' : '';
                                            $buttonClass   = (Request::is('admin/income/monthly-income/'.strtolower($monthName))) ? 'btn-success' : 'btn-primary';
                                            $isMonth       = ( date('M') == $monthName && Request::is('admin/income/month') ) ? 'btn-success' : '';
                                        ?>
                                        <a href="{{ route('monthly.income', strtolower($monthName)) }}" class="btn {{ $buttonClass }} {{$isMonth}} {{ $disabled }}">
                                            {{ $monthName }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- filter month's day data --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            @if( Request::is('admin/income/month') )
                                <?php  
                                    $theMonth = date('M');
                                ?>
                                Show Month's ({{$theMonth}}) Day Incomes
                            @else
                                Show Month's ({{$theMonth}}) Day Incomes
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="row monthlyExpense">
                                <form action="{{route('monthly.day.income')}}" method="GET">
                                    <input type="hidden" name="year" value="{{date('Y')}}">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" name="date" onchange="this.form.submit()" value="{{$date}}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </form>
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
    {{-- delete expense --}}
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function() {
                var deleteButton = $(this); 
                
                var expenseId = deleteButton.data('expense-id');

                // Trigger SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this expense data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    // Handle the user's response
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the customer
                        $.ajax({
                            type: 'DELETE',
                            url: '/admin/expenses/delete/' + expenseId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {    
                                // Remove the row from the table
                                deleteButton.closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });

                                setTimeout(() => {
                                    Swal.fire('Deleted!', 'Expense has been deleted.', 'success');
                                }, 1000);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle deletion error
                                Swal.fire('Error!', 'Failed to delete expenses.', 'error');
                            }
                        });
                    }
                });
            });
        });
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
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

@endsection