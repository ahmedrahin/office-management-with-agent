@extends('backend.layout.template')
@section('page-title')
    <title>Manage Year income || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    {{-- custom --}}
    <style>
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
    </style>
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

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
                                <li class="breadcrumb-item active">Manage Year incomes</li>
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
                                Manage Incomes
                                <span class="text-danger">({{$year}})</span>
                                <div class="btn btn-group">
                                    <a href="{{route('manage.income')}}" class="btn btn-primary">All</a>
                                    <a href="{{route('today.income')}}" class="btn btn-primary" >Today</a>
                                    <a href="{{route('month.income')}}" class="btn btn-primary">This Month</a>
                                    <a href="{{route('year.income')}}" class="btn btn-primary" style="background: #0c7dc2;">This Year</a>
                                </div>
                            </h4>
                            <div class="data table-responsive">
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
                                                <th>Month</th>
                                                <th>Date</th>
                                                <th>Added by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; // Initialize counter variable
                                                // Define an array to map month numbers to their names
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
                                                    <td>{{$months[$expense->month]}}</td>
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
                                                        <button class="deleteButton" data-income-id="{{ $expense->id }}">
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
                            This Year All Expenses Cost
                        </div>
                        <div class="card-body">
                            <blockquote class="card-blockquote mb-0">
                                <h4>Total Expenses:
                                    <span class="text-danger" style="float: right;">
                                        @php
                                            $totalExpense = $expenses->count();
                                            echo $totalExpense;
                                        @endphp
                                    </span>
                                </h4>
                                <hr>
                                <h4>Total Expenses Amount:
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

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Select year 
                        </div>
                        <div class="card-body">
                            <blockquote class="card-blockquote mb-0">
                                <form action="{{route('year.filter')}}" method="GET">
                                    <select name="year" onchange="this.form.submit()">
                                      
                                        @foreach($allYear as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                   </select>
                                </form>
                            </blockquote>
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
                                // $('.exp_info').html(response.html)
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


@endsection