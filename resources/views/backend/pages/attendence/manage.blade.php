@extends('backend.layout.template')
@section('page-title')
    <title>Manage Addentance || {{ \App\Models\Settings::site_title() }}</title>
@endsection

@section('page-css')
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
                                <li class="breadcrumb-item active">Manage Addentance</li>
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

                            <h4 class="card-title" style="display: flex;justify-content: space-between;align-items:center;">
                                <div>
                                    Manage Addentance
                                </div>
                                <div>
                                    <a class="btn btn-primary" href="{{ route('custom.attendance') }}" style="margin-right: 10px;">Take Date Wise Attendance</a>
                                </div>
                            </h4>
                            <div class="data">
                                @if( $attendances->count() == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found!
                                    </div>
                                @else
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Attendance Date</th>
                                                <th>Day</th>
                                                <th>Attendance Year</th>
                                                <th>Attendances</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $counter = 1; // Initialize counter variable
                                            @endphp
                                            @foreach ($attendances as $attendance)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>
                                                        {{$attendance->att_date}}
                                                        @if( today()->format('d M, Y') == $attendance->att_date )
                                                            <span class="text-danger">(Today)</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($attendance->att_date)->format('l') }}
                                                    </td>
                                                    <td>{{$attendance->att_year}}</td>
                                                    <td class="text-center">
                                                        @if( $attendance->is_holiday == 0 )
                                                            <div class="badge bg-danger">Absence: {{$attendance->absence_count}}</div>
                                                            <br>
                                                            <div class="badge bg-success">Present: {{$attendance->present_count}}</div>
                                                        @else
                                                            {!! $attendance->present_count > 0 ? '<div class="badge bg-success">Present:' . $attendance->present_count . '</div><br>' : ''  !!}
                                                            <div class="badge bg-dark">Holiday</div>
                                                        @endif
                                                    </td>
                                                    <td class="action">
                                                        <button>
                                                            <a href="{{route('edit.attendance', $attendance->edit_date)}}" class="btn btn-primary">
                                                               Edit & View
                                                            </a>
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
                
                                        <a href="{{ route('manage.attendance', ['month' => strtolower($monthName), 'year' => $selectedYear]) }}" 
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
                                    <a href="{{ route('manage.attendance', ['year' => $availableYear, 'month' => (Carbon::now()->format('M'))]) }}" 
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