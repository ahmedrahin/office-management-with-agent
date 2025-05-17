@extends('backend.layout.template')
@section('page-title')
    <title>My Task List  || {{ \App\Models\Settings::site_title() }} </title>
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
        .form-check-input{
            padding: 8px;
            display: inline;
            margin: 0;
        }
    </style>
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
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
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Tasks</li>
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
                                My Task List - {{ $filterTitle }} Tasks
                                <div>
                                    <span class="badge bg-dark">Total Tasks: {{ $data->count() }}</span>
                                    <span class="badge bg-danger">Pending: {{ $pendingCount }}</span>
                                    <span class="badge bg-success">Complete: {{ $completeCount }}</span>
                                    <span class="badge bg-primary">Re-schedule: {{ $reScheduleCount }}</span>
                                </div>
                            </h4>
                            <div class="data table-responsive">
                                @if( $data->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Task</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Time</th>
                                               
                                                <th class="text-center">Added by</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; 
                                                
                                            @endphp
                                            @foreach ($data as $v)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{ $v->tasks }}</td>
                                                    <td class="text-center">{{ $v->date }}</td>
                                                    <td class="text-center">{{ $v->time ?? '-' }}</td>
                                                    <td class="text-center"><span class="badge bg-dark">{{ optional($v->user)->name ?? 'N/A' }}</td>
                                                   <td class="text-center">
                                                        @if( $v->status === 're-schedule' )
                                                            <span class="badge bg-info">Re-schedule</span>
                                                        @else
                                                            <label class="form-check-inline">
                                                                <input 
                                                                    class="form-check-input status-radio" 
                                                                    type="radio" 
                                                                    name="status_{{ $v->id }}" 
                                                                    value="pending"
                                                                    data-id="{{ $v->id }}"
                                                                    {{ $v->status == 'pending' ? 'checked' : '' }} 
                                                                >
                                                                Pending
                                                            </label>

                                                            <label class="form-check-inline">
                                                                <input 
                                                                    class="form-check-input status-radio" 
                                                                    type="radio" 
                                                                    name="status_{{ $v->id }}" 
                                                                    value="complete"
                                                                    data-id="{{ $v->id }}"
                                                                    {{ $v->status == 'complete' ? 'checked' : '' }}
                                                                >
                                                                Complete
                                                            </label>
                                                        @endif
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

             <div class="row">

               <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <strong>Filter Your Tasks</strong>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('my.tasks', auth()->user()->employees->id) }}">
                            <select name="filter" id="taskFilter" class="form-control" onchange="this.form.submit()">
                                <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today Tasks</option>
                                <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>This Week Tasks</option>
                                <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>This Month Tasks</option>
                                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

               
                @if( $data->count() != 0 )
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <strong>Task Status Overview</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="taskStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            
        </div> 
    </div>
    <!-- End Page-content -->
                
@endsection

@section('page-script')
    
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('taskStatusChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Re-schedule', 'Complete'],
                    datasets: [{
                        label: 'Task Status',
                        data: [{{ $pendingCount }}, {{ $reScheduleCount }}, {{ $completeCount }}],
                        backgroundColor: [
                            '#FFC107', 
                            '#17A2B8', 
                            '#28A745' 
                        ],
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return label + ': ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.status-radio').on('change', function() {
                var taskId = $(this).data('id');
                var newStatus = $(this).val();
                
                $.ajax({
                    url: "{{ route('task.update.status') }}", 
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: taskId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated',
                                text: 'The task status has been updated successfully!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'There was an issue updating the status. Please try again.'
                        });
                    }
                });
            });
        });

    </script>

@endsection