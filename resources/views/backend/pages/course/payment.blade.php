@extends('backend.layout.template')

@section('page-title')
    <title>Course Payement || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <style>
        button[type="submit"].del {
            width: 18px !important;
            padding: 0 !important;
            height: 18px;
            border: none;
            display: inline !important;
            background: #ff0000bf;
            color: white;
            font-size: 12px;
        }
        .student-card {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .student-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
        }
        .info-group {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .session, .delete {
            font-size: 16px;
            font-weight: 700;
            padding: 15px;
        }
        .payment-box {
            padding: 30px;
            width: 80%;
            margin: auto;
            margin-top: 30px;
            margin-bottom: 40px;
        }
        h4 {
            font-size: 17px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }
        
    </style>
@endsection

@section('body-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card student-card">
                        @if( session('success') )
                            <div class="badge bg-success session">{{ session('success') }}</div>
                        @endif
                        @if( session('delete') )
                            <div class="badge bg-danger delete">{{ session('delete') }}</div>
                        @endif
                        <div class="card-body text-center">
                            <img src="{{ $data->registation->image ? asset($data->registation->image) : asset('backend/images/user.jpg') }}" class="student-img" alt="Student Image">
                            <h3 class="mt-3"><a href="{{ route('student-registration.show', $data->registation->id) }}" target="_blank">{{ $data->registation->name }}</a></h3>

                        </div>
                        <div class="card-body">
                            <div class="info-group">
                                <strong>Course Name:</strong>
                                <span>{{ $data->course->name }} - ({{ $data->course->fees }}tk)</span>
                            </div>
                            <div class="info-group">
                                <strong>Enrolled Date:</strong>
                                <span>{{ $data->start_date }}</span>
                            </div>
                            <div class="info-group">
                                <strong>Enrolled by:</strong>
                                <span>{{ optional($data->user)->name ?? 'N/A' }}</span>
                            </div>

                            <form action="{{ route('payment.update') }}" method="POST">
                                @csrf
                                <div>
                                    <div class="card payment-box">
                                        <h4>Add New Payment</h4>
                                        <strong>Payment Amount:</strong>
                                        <input type="number" name="payment" class="form-control my-2" placeholder="Enter amount" min="1" required>
                                        <input name="id" value="{{ $data->id }}" hidden>
                                        <input name="registation_id" value="{{ $data->registation->id }}" hidden>
                                        <input name="course_id" value="{{ $data->course->id }}" hidden>
                                        <button type="submit" class="btn btn-primary">Add Payment</button>
                                    </div>
                                </div>
                            </form>

                            <div class="payment-summary">
                                <h4>Payment Ladger</h4>
                                <table class="table table-bordered text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th class="text-center">Del.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->payment as $paid)
                                        <tr>
                                            <td>{{ $paid->created_at->format('d, M, Y') }}</td>
                                            <td>
                                                <span class="{{ $paid->payment == 0 ? '' : 'text-success' }}">
                                                    @if( $paid->payment != 0 )
                                                        ৳{{ number_format($paid->payment, 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span class="{{ $paid->due_payment <= 0 ? 'text-success' : 'text-danger' }}">
                                                    ৳{{ number_format($paid->due_payment, 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center" style="width:8%;">
                                                @if( $paid->payment != 0 )
                                                    <form action="{{ route('delete.payment',$paid->id) }}" id="deleteForm">
                                                        @csrf
                                                        <button type="submit" class="del" onclick="confirmDelete(event)">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                @else 
                                                 -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            
                                <!-- Payment Summary Section -->
                                <div class="totals mt-3 mb-3 p-3 bg-light rounded shadow-sm">
                                    <h4 class="text-center mb-3"><strong>Payment Summary</strong></h4>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span><strong>Total Fees:</strong></span>
                                        <span class="badge bg-primary px-3 py-2">৳{{ number_format($data->course->fees, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span><strong>Total Paid:</strong></span>
                                        <span class="badge bg-success px-3 py-2">৳{{ number_format($data->payment->sum('payment'), 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @php
                                            $lastPayment = $data->payment->last(); 
                                            $lastDueAmount = $lastPayment ? $lastPayment->due_payment : 0;
                                        @endphp
                                        <span><strong>Remaining Due:</strong></span>
                                        <span class="badge px-3 py-2" style="background-color: {{ $lastDueAmount <= 0 ? '#28a745' : '#dc3545' }}; color: #fff;">
                                            ৳{{ number_format($lastDueAmount, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="card-footer text-center">
                            <button onclick="printInvoice({{ $data->id }})" class="btn btn-success" style="margin-left: 3px;">
                                <i class="fa fa-print"></i> Invoice Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-script')
    <script>
         function printInvoice(id) {
            let url = "{{ route('invoice', ':id') }}".replace(':id', id);
            let printWindow = window.open(url, '_blank');
            
            printWindow.onload = function () {
                printWindow.print();
            };
        }

        function confirmDelete(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
            if (confirm('Are you sure you want to delete this payment?')) {
                // If user confirms, submit the form
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection