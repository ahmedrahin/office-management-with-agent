@extends('backend.layout.template')

@section('page-title')
    <title> Salary Report || {{ \App\Models\Settings::site_title() }}</title>
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
        .student-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
        }
    </style>
@endsection

@section('body-content')
    @php
        use Carbon\Carbon;
        $date = Carbon::parse(request('month', date('M')) . ' ' . request('year', date('Y')))->format('F Y');
        $advance = App\Models\AdvanceSalary::where('employees_id', $employee->id)->where('salary_month', $month)->where('salary_year', $year)->first();
    @endphp


    <div class="page-content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Salary Report</li>
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
                            <h4 class="card-title mb-3">Salary Report - {{ $employee->name }}</h4>
                            <div class="card-body text-center pt-0">
                                <img src="{{ $employee->image ? asset($employee->image) : asset('backend/images/user.jpg') }}" class="student-img" alt="Student Image">
                                <h3 class="mt-3">{{ $employee->name }}</h3>
                                <p class="text-muted">{{ $employee->phone ?? 'No Email Provided' }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered salary-details-table">
                                    <tbody>
                                        <tr>
                                            <th>Employee Name:</th>
                                            <td>{{ $employee->name }} <span class="badge bg-primary">{{ $employee->employee_office_id }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Designation:</th>
                                            <td>{{ $employee->position }}</td>
                                        </tr>
                                        <tr>
                                            <th>Join Date:</th>
                                            <td>{{ $employee->join_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Salary Amount:</th>
                                            <td>{{ number_format($employee->salary, 2) }} tk</td>
                                        </tr>
                                        <tr>
                                            <th>Salary Date:</th>
                                            <td>{{ $date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Issue Date:</th>
                                            <td>{{ optional($employee->salaries->sortByDesc('created_at')->first())->created_at?->format('j M Y') }}</td>
                                        </tr>

                                        @if( optional($employee->salaries->first())->description )
                                            <th>Description:</th>
                                            <td>{{ optional($employee->salaries->first())->description }}</td>
                                        @endif


                                        @php
                                            $monthNumber = Carbon::parse($month . ' 1 ' . $year)->format('m');
                                            $totalDaysInMonth = Carbon::createFromDate($year, $monthNumber)->daysInMonth;
                                            $payableAmount = $employee->salary / $totalDaysInMonth;
                                            $absenceAmount = round($payableAmount * $employee->attendance->count());
                                            $paid = $totalDaysInMonth * $payableAmount - $absenceAmount;
                                            if( $advance ){
                                                $paid = $totalDaysInMonth * $payableAmount - $absenceAmount - $advance->adv_salary;
                                            }
                                        @endphp
                                        <tr>
                                            <th>Absence this month:</th>
                                            <td>
                                                @if($employee->attendance->count() > 0)
                                                    <span class="badge bg-danger">{{ $employee->attendance->count() }}</span> <span class="text-danger">(-{{ $absenceAmount }}tk)</span>
                                                @else
                                                    <span class="badge bg-success">0</span>
                                                @endif
                                            </td>
                                        </tr>

                                        @if( $employee->salaries->first()->adv_salary )
                                            <tr>
                                                <th>Advance for this month:</th>
                                                <td>
                                                    <span class="text-success">(+{{ number_format($employee->salaries->first()->adv_salary, 2) }} tk)</span>
                                                    <span class="text-warning">({{ $employee->salaries->first()->adv_percent }}%)</span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if( $employee->salaries->first()->due )
                                            <tr>
                                                <th>Due:</th>
                                                <td>{{ number_format($employee->salaries->first()->due, 2) }} tk</td>
                                            </tr>
                                        @endif

                                        @if( $employee->salaries->first()->cut_salary  )
                                           <tr>
                                                <th>Reduced Amount:</th>
                                                <td>{{ number_format($employee->salaries->first()->cut_salary, 2) }} tk</td>
                                           </tr>
                                        @endif

                                        @if( $employee->salaries->first()->salary_note )
                                           <tr>
                                                <th>Reduced Reason:</th>
                                                <td>{{ $employee->salaries->first()->salary_note }}</td>
                                           </tr>
                                        @endif

                                        @if( $employee->salaries->first()->bonus )
                                            <tr>
                                                <th>Bonus:</th>
                                                <td>{{ number_format($employee->salaries->first()->bonus, 2) }} tk</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>Paid Amount:</th>
                                            <td><strong>{{ number_format($employee->salaries->first()->salary , 2) }} tk</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button onclick="window.print()" class="btn btn-success btn-lg mt-3">
                                    <i class="fa fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
