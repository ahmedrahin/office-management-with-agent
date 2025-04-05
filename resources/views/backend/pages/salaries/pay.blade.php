@extends('backend.layout.template')

@section('page-title')
    <title>Pay Salary || {{ \App\Models\Settings::site_title() }}</title>
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
    $check = App\Models\Salarie::where('employees_id', $employee->id)->where('salary_month', $month)->where('salary_year', $year)->first();
    $advance = App\Models\AdvanceSalary::where('employees_id', $employee->id)->where('salary_month', $month)->where('salary_year', $year)->first();
@endphp

@if( !($check) )
<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="page-title">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                            <li class="breadcrumb-item active">Pay Salary</li>
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
                        <h4 class="card-title mb-3">Pay Salary - {{ $employee->name }}</h4>
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

                                    @if( $advance )
                                        @php
                                            $advancePercentage = round(($advance->adv_salary / $employee->salary) * 100);
                                        @endphp
                                        <tr>
                                            <th>Advance for this month:</th>
                                            <td>
                                                <span class="text-danger">(-{{ number_format($advance->adv_salary, 2) }} tk)</span>
                                                <span class="text-warning">({{ $advancePercentage }}%)</span>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th>Payable Amount:</th>
                                        <td><strong class="{{ $paid < 0 ? 'text-danger' : '' }}" >{{ number_format($paid, 2) }} tk</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('paid.salary') }}" method="POST" class="needs-validation mt-2" novalidate>
                            @csrf

                            @if( $advance )
                                <input type="hidden" name="adv_salary" value="{{ $advance->adv_salary }}">
                                <input type="hidden" name="adv_percent" value="{{ $advancePercentage }}">
                            @endif

                            <div class="row">
                                <input name="employees_id" value="{{ request('id') }}" hidden>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary Amount</label>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ $paid }}">
                                        @error('salary')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="salary_note" class="form-label">Issues</label>
                                        <select name="salary_note" id="salary_note">
                                            <option value="" selected>Full Payment</option>
                                            <option value="absence">For Absence</option>
                                            <option value="fine">Fine</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Salary Month</label>
                                        <input type="text" class="form-control" name="date" value="{{ $date }}" readonly>
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
                                        <label for="bonus" class="form-label">Bonus</label>
                                        <input type="number" name="bonus" id="bonus">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="details" class="form-label">Write Details</label>
                                <textarea id="elm1" class="form-control" placeholder="Write Details.." name="details" rows="5">{{ old('details') }}</textarea>
                            </div>

                            <button class="btn btn-primary pay-now-btn" type="submit" id="addExpense">
                                <i class="fas fa-money-bill-wave"></i> Pay Now
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif

@endsection


@section('page-script')
    <script>
       document.addEventListener("DOMContentLoaded", function () {
            const salaryInput = document.getElementById("salary");
            const dueInput = document.getElementById("due");

            dueInput.addEventListener("input", function () {
                let salary = parseFloat("{{ $paid }}") || 0;  
                let due = parseFloat(dueInput.value) || 0;  

                salaryInput.value = (salary - due).toFixed(0); 
            });
        });
    </script>
@endsection