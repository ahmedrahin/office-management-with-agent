@extends('backend.layout.template')

@section('page-title')
    <title>Expense Details || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('body-content')
<!-- Start Page-content -->
<div class="page-content">
    <div class="container-fluid">
        <!-- Start Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="page-title">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ \App\Models\Settings::site_title() }}</a></li>
                            <li class="breadcrumb-item active">Expense Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        @php
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

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-lg border-0 rounded">
                    <div class="card-body">
                        @include('backend.includes.company')
                        <h4 class="card-title d-flex justify-content-between align-items-center">
                            <div>Expense Details</div>
                            {{-- <div>
                                <a href="{{ route('manage.expenses') }}" class="btn btn-primary">All Expense List</a>
                            </div> --}}
                        </h4>

                        <!-- Expense Data - Side by Side Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Expense Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Expense Name & Employee -->
                                    <tr>
                                        <td><strong>Expense Name</strong></td>
                                        <td class="text-muted">{{ $expense->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Employee</strong></td>
                                        <td class="text-muted">
                                            @if($expense->employees)
                                                <div class="d-flex align-items-center">
                                                    <a href="">
                                                        @if($expense->employees->image)
                                                            <img src="{{ asset($expense->employees->image) }}" alt="Employee Image" class="rounded-circle image" width="45" height="45">
                                                        @else
                                                            <img src="{{ asset('backend/images/user.jpg') }}" alt="Employee Image" class="rounded-circle image" width="45" height="45">
                                                        @endif
                                                        <span class="ml-3">{{ optional($expense->employees)->name ?? 'N/A' }}</span>
                                                    </a>
                                                </div>
                                            @else
                                                <p class="text-muted">No employee assigned</p>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Expense Details -->
                                    <tr>
                                        <td><strong>Expense Details</strong></td>
                                        <td class="text-muted">{!! $expense->details ?? 'No details provided' !!}</td>
                                    </tr>

                                    <!-- Amount, Month, Date, Year -->
                                    <tr>
                                        <td><strong>Amount</strong></td>
                                        <td class="text-muted">{{ number_format($expense->amn, 2) }} tk</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Month</strong></td>
                                        <td class="text-muted">{{ $months[$expense->month] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td class="text-muted">{{ $expense->date }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Year</strong></td>
                                        <td class="text-muted">{{ $expense->year }}</td>
                                    </tr>

                                    <!-- Expense Image -->
                                    <tr>
                                        <td><strong>Expense Memo</strong></td>
                                        <td>
                                            @if($expense->image)
                                                <div class="img-fluid border rounded">
                                                    <img src="{{ asset($expense->image) }}" alt="Expense Image" class="rounded shadow-sm memo">
                                                </div>
                                            @else
                                                <p class="text-muted">No image uploaded</p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Print Button -->
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
<!-- End Page-content -->
@endsection

@section('page-css')
<style>
    .card-body {
        padding: 2rem;
    }

    .breadcrumb {
        background: transparent;
    }

    .card-title {
        font-size: 1.5rem;
        color: #007bff;
    }

    .table th, .table td {
        vertical-align: middle;
        font-size: 14px !important;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .table td {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .img-fluid {
        max-width: 100%;
    }

    .shadow-lg {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-lg {
        font-size: 1.25rem;
        padding: 0.75rem 1.25rem;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn i {
        margin-right: 10px;
    }

    .image {
        border: 2px solid #ddd;
        padding: 2px;
        border-radius: 50%;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .memo {
        max-width: 80%;
        max-height: 400px;
    }
</style>
@endsection
