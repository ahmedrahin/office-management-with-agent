@extends('backend.layout.template')
@section('page-title')
    <title>Admin Dashboard || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('body-content')
    <!-- start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Income</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Income::sum('amn') }}tk
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Expense</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Expense::sum('amn') }}tk
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-danger rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Employees::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Student</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Registation::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Tourist</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Tourist::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-danger rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Job Inquiries</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\JobInquiry::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-dark rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Agents</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Agent::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-secondary rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Countries</p>
                                    <h4 class="mb-2">
                                        {{ App\Models\Country::count() }}
                                    </h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-secondary rounded-3">
                                        <i class="ri-earth-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

            </div><!-- end row -->

            @php
                $today = Carbon\Carbon::now()->format('d M, Y');
                $appoinment = App\Models\Appoinment::where('date', $today)->latest()->get();
                $task = App\Models\Task::where('date', $today)->latest()->get();
            @endphp


            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title mb-4">Today's Appoinment ({{ $appoinment->count() }})</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Person Name</th>
                                            <th class="text-center">Person Phone</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appoinment as $v)
                                            <tr>
                                                <td>{{ $v->person_name }}</td>
                                                <td class="text-center">{{ $v->phone ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ $v->employees->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $v->time ?? '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody><!-- end tbody -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title mb-4">Today's Tasks ({{ $appoinment->count() }})</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Task Name</th>
                                            <th class="text-center">Assign To</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task as $v)
                                            <tr>
                                                <td>{{ $v->person_name }}</td>
                                                <td class="text-center">{{ $v->phone ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ $v->employees->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $v->time ?? '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody><!-- end tbody -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">


                </div>
                <!-- end col -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h4 class="card-title mb-4">Income</h4>

                            <div class="text-center pt-3">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div>
                                            <h5>{{ number_format($yearIncome, 2) }}</h5>
                                            <p class="text-muted text-truncate mb-0">This Year</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div>
                                            <h5>{{ number_format($lastWeekIncome, 2) }}tk</h5>
                                            <p class="text-muted text-truncate mb-0">Last Week</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div>
                                            <h5>{{ number_format($lastMonthIncome, 2) }}tk</h5>
                                            <p class="text-muted text-truncate mb-0">Last Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Section -->
                        <div class="card-body py-0 px-2">
                            <div id="column_line_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>


        </div>
    </div>
    <!-- End Page-content -->
@endsection


@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var monthlyIncomeData = @json(array_values($monthlyIncome->toArray()));
            var monthlyCategories = @json(array_keys($monthlyIncome->toArray()));

            console.log("Chart Data:", monthlyIncomeData);
            console.log("Chart Categories:", monthlyCategories);

            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Income',
                    data: monthlyIncomeData
                }],
                xaxis: {
                    categories: monthlyCategories
                }
            };

            if (document.querySelector("#column_line_chart")) {
                var chart = new ApexCharts(document.querySelector("#column_line_chart"), options);
                chart.render();
            } else {
                console.error("Chart container not found!");
            }
        });
    </script>
@endsection
