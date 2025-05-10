@extends('backend.layout.template')
@section('page-title')
    <title>Monthly Attendence Report || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
    <link href="{{asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
    <style>
        .disabled {
            pointer-events: none; 
            opacity: 0.4 !important; 
            cursor: default;
        }
        .monthlyExpense .btn-primary, .monthlyExpense .btn-success {
            margin-bottom: 9px;
            margin-left: 5px;
        }
        input[type="radio"]{
            padding: 0 !important;
        }
        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table label i {
            padding-left: 6px;
        }
        
        table label {
            display: flex;
            align-items: center;
        }
        .ri-checkbox-circle-line {
            color: #03c003;
            padding-left: 12px;
        }
        .ri-close-circle-line {
            color: #ff0000ba;
        }
        
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title span {
            font-weight: 800;
            font-size: 16px;
        }
        td label {
            display: inline;
            float: right;
            padding-right: 50px;
        }
    </style>
@endsection

@section('body-content')

    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <div class="page-title">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{ \App\Models\Settings::site_title() }}</a></li>
                                <li class="breadcrumb-item active">Monthly Attendence Report</li>
                            </ol>
                        </div>


                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                    @if( Request::is('admin/attendence/month-attendance') )
                                       Monthli Attendences
                                    @else
                                        {{$getMonth}} Month Attendences
                                    @endif
                                <span class="text-danger">
                                    @if( Request::is('admin/attendence/month-attendance') )
                                        {{date('M-Y')}}
                                    @else
                                        {{$getMonth}}
                                    @endif
                                </span>
                            </h4>
                            @if( $employees->count() == 0 )
                                <div class="alert alert-danger" role="alert">
                                    No Data Found!
                                </div>
                            @else
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Image</th>
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Attendences Report</th>
                                            <th class="text-center">Details</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $counter = 1; // Initialize counter variable
                                        @endphp
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{$counter++}}</td>
                                            <td>
                                                @if( !is_null($employee->image) )
                                                    <img src="{{asset($employee->image)}}" alt="" class="user-img">
                                                @else
                                                    <img src="{{asset('backend/images/user.jpg')}}" alt="" class="user-img">
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $employee->employee_office_id }}</span>
                                            </td>
                                            <td>{{$employee->name}} {{$employee->position ? '(' . $employee->position .')'  : ''}}</td>
                                    
                                            <td>
                                                @if( Request::is('admin/attendence/month-attendance') )
                                            
                                                @else
                                                    @if( ($isMonthExists) )
                                                        @php
                                                            $monthMapping = [
                                                                "Jan" => 1, "Feb" => 2, "Mar" => 3, "Apr" => 4, "May" => 5, "Jun" => 6,
                                                                "Jul" => 7, "Aug" => 8, "Sep" => 9, "Oct" => 10, "Nov" => 11, "Dec" => 12,
                                                            ];
                                            
                                                            $currentMonth = $monthMapping[$month];
                                                            $currentYear = $year;
                                            
                                                            // Get days passed in the selected month
                                                            $daysPassed = ($currentMonth == date('m') && $currentYear == date('Y')) 
                                                                ? date('d') 
                                                                : cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                                            
                                                            // Fetch attendance data
                                                            $present = App\Models\Attendance::where('att_year', $currentYear)
                                                                ->where('month', $month)
                                                                ->where('emp_id', $employee->id)
                                                                ->where('att', 'present')
                                                                ->count();
                                            
                                                            $absence = App\Models\Attendance::where('att_year', $currentYear)
                                                                ->where('month', $month)
                                                                ->where('emp_id', $employee->id)
                                                                ->where('att', 'absence')
                                                                ->count();
                                            
                                                            $holidays = App\Models\Attendance::where('att_year', $currentYear)
                                                                ->where('month', $month)
                                                                ->where('emp_id', $employee->id)
                                                                ->where('att', 'holiday')
                                                                ->count();
                                            
                                                            // Calculate attendance not taken days
                                                            $notTaken = $daysPassed - ($present + $absence + $holidays);
                                                        @endphp
                                            
                                                        {{"Days Passed: " . $daysPassed}} 
                                                        <label class="badge bg-success"> Present: {{$present}} days</label>
                                                        <label class="badge bg-warning mx-1"> Holiday: {{$holidays}} days</label>
                                                        <label class="badge bg-danger"> Absence: {{$absence}} days</label>
                                                        <label class="badge bg-secondary mx-1"> Not Taken: {{$notTaken}} days</label>
                                            
                                                    @else
                                                        <span class="empty text-danger">No attendance taken this month</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div>
                                                    <a href="{{ route('details.attendance', ['employee_id' => $employee->id, 'month' => $month, 'year' => $year]) }}" 
                                                        class="btn btn-primary" target="_blank" style="padding-bottom: 1px !important;padding: 3px 8px;">
                                                         <i class="ri-eye-line"></i>
                                                     </a>                                                     
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- end card -->
                </div> 
            </div>
            <!-- end row -->

            <div class="row">
                {{-- filter others month data --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            Show Others Month's ({{ request('year', date('Y')) }}) Attendance Report
                        </div>
                
                        <div class="card-body">
                            <div class="row monthlyExpense">
                                <div class="col-12">
                                    @php
                                        $currentMonth = date('n'); 
                                        $selectedYear = request('year', date('Y')); 
                                        $currentYear = date('Y');
                                    @endphp
                                    
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $monthName = \Carbon\Carbon::create($selectedYear, $i, 1)->format('M');
                                            $disabled = ($selectedYear == $currentYear && $i > $currentMonth) ? 'disabled' : ''; 
                                            $buttonClass = (strtolower(request('month')) == strtolower($monthName)) ? 'btn-success' : 'btn-primary';
                                            $isCurrentMonth = (strtolower(date('M')) == strtolower($monthName) && request('month') == null) ? 'btn-success' : '';
                                        @endphp
                
                                        <a href="{{ route('monthly.attendance', ['month' => strtolower($monthName), 'year' => $selectedYear]) }}" 
                                        class="btn {{ $buttonClass }} {{ $isCurrentMonth }} {{ $disabled }}">
                                            {{ $monthName }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    use Carbon\Carbon;
                @endphp

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <strong>Select Year</strong>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($allYear as $availableYear)
                                    <a href="{{ route('month.attendance', ['year' => $availableYear, 'month' => (Carbon::now()->format('M'))]) }}" 
                                    class="btn btn-primary mb-2 {{ request('year') == $availableYear ? 'btn-success text-white' : '' }}"
                                    style="width: 45%; text-align: center;">
                                        {{ $availableYear }}
                                    </a>
                                @endforeach
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
    <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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