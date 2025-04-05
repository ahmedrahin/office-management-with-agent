@extends('backend.layout.template')
@section('page-title')
    <title>Attendance Report || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
<style>
    .attendance-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .attendance-header {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }
    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }
    .attendance-table th, .attendance-table td {
        text-align: center;
        padding: 12px;
        border: 1px solid #ddd;
    }
    .attendance-table th {
        background: #007bff;
        color: #fff;
        font-weight: bold;
    }
    .attendance-table td {
        font-size: 16px;
        position: relative;
        min-width: 80px;
        height: 80px;
    }
    .badge {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 20px;
        display: inline-block;
        font-weight: bold;
    }
    .bg-success { background-color: #28a745; color: #fff; }  /* Present */
    .bg-danger { background-color: #dc3545; color: #fff; }  /* Absent */
    .bg-warning { background-color: #ffc107; color: #212529; } /* Late */
    .bg-secondary { background-color: #6c757d; color: #fff; } /* Offday */
    .bg-light { background-color: #f8f9fa; color: #495057; } /* Not Taken */
    .day {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #343a40;
    }
    .card-custom {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    .card-header {
        background: #007bff;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 12px;
    }

        @media print {
        * {
            -webkit-print-color-adjust: exact !important; /* Ensure colors print correctly */
            print-color-adjust: exact !important;
        }

        body {
            margin: 0;
            padding: 5px;
        }

        .attendance-container {
            box-shadow: none;
            border: none;
            padding: 5px;
        }

        .attendance-table {
            font-size: 12px; /* Reduce font size for better fit */
            width: 100%;
            table-layout: fixed; /* Ensure consistent table width */
        }

        .attendance-table td, .attendance-table th {
            padding: 5px; /* Reduce padding */
            word-wrap: break-word;
        }

        .attendance-table tr {
            page-break-inside: avoid !important; /* Prevent rows from splitting */
        }

        .card-custom {
            page-break-inside: avoid; /* Prevent breaking inside cards */
        }

        .btn {
            display: none; /* Hide print button */
        }

        /* Ensure table is fully visible in print */
    
    }

</style>
@endsection

@section('body-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="attendance-container">
                    <div class="attendance-header">Attendance Report for <strong>{{ $employee->name }}</strong></div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-custom">
                                <div class="card-header">Attendance Summary</div>
                                <div class="card-body" style="padding-bottom: 0;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>Holiday</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-success">{{ $totalPresent }} Days</span></td>
                                                <td><span class="badge bg-danger">{{ $totalAbsent }} Days</span></td>
                                                <td><span class="badge bg-warning">{{ $totalHoliday }} Days</span></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="3" style="font-size: 16px;font-weight:700;color:red;">Date: {{ $month }}-{{ $year }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th>Sunday</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $startDay = date('w', strtotime("$year-$month-01"));
                                $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month . ' 1')), $year);
                                $day = 1;
                            @endphp
                            @for ($week = 0; $week < 6; $week++)
                                <tr>
                                    @for ($weekday = 0; $weekday < 7; $weekday++)
                                        <td>
                                            @if ($week === 0 && $weekday < $startDay || $day > $totalDays)
                                                {{-- Empty Cell --}}
                                            @else
                                                <div class="day">{{ $day }}</div>
                                                @php 
                                                    $status = $attendanceData[$day]['status'] ?? 'not_taken'; 
                                                    $badgeClass = match($status) {
                                                        'present' => 'bg-success',
                                                        'absence' => 'bg-danger',
                                                        'holiday' => 'bg-warning',
                                                        'not_taken' => 'bg-secondary',
                                                        default => 'bg-light'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                                @php $day++; @endphp
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    
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
@endsection
