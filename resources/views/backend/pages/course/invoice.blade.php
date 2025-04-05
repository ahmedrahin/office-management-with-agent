<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @media print {
            body {
                background: none;
                color: black;
                font-size: 12px;
            }
            .container {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            .receipt-table th {
                background-color: #D49C15 !important;
                color: white !important;
                -webkit-print-color-adjust: exact; /* Ensures colors print */
            }
            .receipt-table td {
                border-bottom: 1px solid #ddd !important;
                background: #f9f9f9 !important;
                -webkit-print-color-adjust: exact;
            }
            .totals strong {
                color: black !important;
            }
            .positive-due {
                color: green !important;
            }
            .negative-due {
                color: red !important;
            }
        }
    </style>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 40px;
            background: #f4f4f4;
            font-size: 14px;
        }
        .container {
            width: 700px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            /* align-items: center; */
            margin-bottom: 20px;
        }
        .header h2 {
            color: #D49C15;
            font-weight: 600;
        }
        .logo {
            width: 80px;
            height: 80px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #999;
            border-radius: 5%;
        }
        .positive-due {
            color: green !important;
        }
        .negative-due {
            color: red !important;
        }
        .info {
            margin-bottom: 20px;
        }
        .info div {
            margin-bottom: 5px;
        }
        .receipt-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .receipt-table th {
            background-color: #D49C15;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }
        .receipt-table td {
            padding: 10px;
            border-bottom: 2px solid #fff;
            background: #c0c0c038;
        }
        .receipt-table tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            width: 100%;
            text-align: right;
            margin-top: 20px;
        }
        .totals div {
            margin-bottom: 5px;
        }
        .totals strong {
            font-size: 14px;
        }
        .terms {
            margin-top: 30px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div>
            <h2 class="mt-0 mb-2" style="margin-bottom: 10px !important;">{{ \App\Models\Settings::site_title() }}</h2>
            <div>
                phone : <strong>{{ \App\Models\Settings::call_1()->phone1 }}</strong>
            </div>
            <div>{{ \App\Models\Settings::shop_address() }}</div>
            <div>{{ \App\Models\Settings::city() }}</div>

        </div>

        @php
            $logo = \App\Models\Settings::shop_logo();
        @endphp
        
        @if( $logo )
            <img src="{{asset($logo->logo)}}" alt="" class="avatar-md rounded-circle logo">
        @else
            <div class="logo">LOGO</div>
        @endif
    
    </div>

    <div style="display: flex;align-items:end;justify-content:space-between;">
        <!-- Billed To -->
        <div class="info">
            <div class="receipt-title">Student Information:</div>
            <div>{{ $data->registation->name }}</div>
            <div> phone : <strong>{{ $data->registation->mobile }}</strong></div>
            <div>{{ $data->registation->permanent_address }}, {{ $data->registation->permanent_district }}, {{ $data->registation->permanent_division }}</div> 
            <div>{{ $data->registation->temporary_address }}, {{ $data->registation->temporary_district }}, {{ $data->registation->temporary_division }}</div>
        </div>

        <!-- Receipt Details -->
        <div class="info">
            <div class="receipt-title">RECEIPT</div>
            <div>Receipt Number: <strong>#0{{ $data->id }} {{ $data->course->id }} {{ $data->registation->id }}</strong></div>
            <div>Course Name: <strong>{{ $data->course->name }}</strong></div>
            <div>Course Fees: <strong style="color:red;">৳{{ $data->course->fees }}</strong></div>
            <div>Date of Issue: <strong>{{ $data->start_date }}</strong></div>
        </div>
    </div>

    <!-- Table -->
    <table class="receipt-table">
        <thead>
            <tr>
                <th class="text-center">Payment date</th>
                <th class="text-center">Paid Amount</th>
                <th class="text-center">Due Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->payment as $paid)
            <tr>
                <td class="text-center">{{ $paid->created_at->format('d, M, Y') }}</td>
                <td class="text-center">
                    <span class="{{ $paid->payment == 0 ? '' : 'text-success' }}">
                        @if( $paid->payment != 0 )
                            ৳{{ number_format($paid->payment, 2) }}
                        @else
                            -
                        @endif
                    </span>
                </td>
                <td class="text-center"><span class="text-danger">৳{{ $paid->due_payment }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals" style="fo">
        <div>Fees: <strong>৳{{ number_format($data->course->fees, 2) }}</strong></div>
        <div>Paid: <strong>৳{{ number_format($data->payment->sum('payment'), 2) }}</strong></div>
        <div>
            Due: 
            @php
                $dueAmount = $data->course->fees - $data->payment->sum('payment');
            @endphp
            <strong class="{{ $dueAmount <= 0 ? 'positive-due' : 'negative-due' }}">
                ৳{{ number_format($dueAmount, 2) }}
            </strong>
        </div>
    </div>

    <!-- Terms -->
    <div class="terms">
        TERMS: Please pay invoice by MM/DD/YYYY
    </div>

</div>

</body>
</html>
