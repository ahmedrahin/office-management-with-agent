 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                @php
                    $logo = \App\Models\Settings::shop_logo();
                @endphp
                <img src="{{asset($logo->logo)}}" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{Auth::user()->name}}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{route('home')}}" class="waves-effect">
                        {{-- <i class="ri-home-4-line"></i><span class="badge rounded-pill bg-success float-end">3</span> --}}
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Admin & Agent Management</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user-group"></i>
                        <span>Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.admin-management.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New</a></li>
                        <li><a href="{{route('admin.admin-management.index')}}"><i class="ri-arrow-right-s-fill"></i> Show All</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user-group"></i>
                        <span>Agents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('agent.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New</a></li>
                        <li><a href="{{route('agent.index')}}"><i class="ri-arrow-right-s-fill"></i> Show All</a></li>
                    </ul>
                </li>

                <li class="menu-title">Workforce Management</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user-group"></i>
                        <span>Employees</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('add.employees')}}"> <i class="ri-arrow-right-s-fill"></i> Add New</a></li>
                        <li><a href="{{route('manage.employees')}}"><i class="ri-arrow-right-s-fill"></i> Show All</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-unfollow-line"></i>
                        <span>Attendance</span>
                    </a>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('take.attendance')}}"> <i class="ri-arrow-right-s-fill"></i> Take Attendence </a></li>
                        <li><a href="{{route('manage.attendance', [date('Y'), (Carbon::now()->format('M'))])}}"><i class="ri-arrow-right-s-fill"></i> All Attendences</a></li>
                        <li><a href="{{ route('month.attendance', [date('Y'), (Carbon::now()->format('M'))]) }}"><i class="ri-arrow-right-s-fill"></i> Attendance Report</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('shedule.index')}}" > <i class="ri-arrow-right-s-fill"></i>Work Schedules</a>
                </li>

                <li class="menu-title">Payroll Management</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Salary</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('custom.salary')}}"> <i class="ri-arrow-right-s-fill"></i> Pay Custom Salary</a></li>
                        <li><a href="{{route('pay.list', [date('Y'), (Carbon::now()->format('M'))])}}"><i class="ri-arrow-right-s-fill"></i>Monthly Salary Sheet</a></li>
                        <li><a href="{{route('pay.adv')}}"><i class="ri-arrow-right-s-fill"></i>Pay Advance Salary</a></li>
                        <li><a href="{{route('list.adv')}}"><i class="ri-arrow-right-s-fill"></i>Advance Salary List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('add.expenses')}}"> <i class="ri-arrow-right-s-fill"></i> Add Expense</a></li>
                        <li><a href="{{route('manage.expenses')}}"><i class="ri-arrow-right-s-fill"></i> All Expenses</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>Incomes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('add.income')}}"> <i class="ri-arrow-right-s-fill"></i> Add Income</a></li>
                        <li><a href="{{route('manage.income')}}"><i class="ri-arrow-right-s-fill"></i> All Incomes</a></li>
                    </ul>
                </li>

                <li class="menu-title">Student Registation</li>
                {{-- <li>
                    <a href="{{route('student-registration.index')}}" style="padding-bottom: 0;"> <i class="ri-arrow-right-s-fill"></i>Register Student</a>
                </li>
                <li>
                    <a href="{{route('student-registration.create')}}"> <i class="ri-arrow-right-s-fill"></i>Register Form</a>
                </li> --}}

                {{-- <li class="menu-title">Course Management</li>
                <li>
                    <a href="{{route('course.index')}}" style="padding-bottom: 0;"> <i class="ri-arrow-right-s-fill"></i>Course List</a>
                </li>
                <li>
                    <a href="{{route('assign-course.index', [date('Y'), (Carbon::now()->format('M'))])}}" style="padding-bottom: 0;"> <i class="ri-arrow-right-s-fill"></i>Enroll Course</a>
                </li> --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>Countries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('country.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New Country</a></li>
                        <li><a href="{{route('country.index')}}"><i class="ri-arrow-right-s-fill"></i> All Country List</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>Job Type</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('job.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New job</a></li>
                        <li><a href="{{route('job.index')}}"><i class="ri-arrow-right-s-fill"></i> All Job List</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>Tourist Places</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('tourist.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New Tourist</a></li>
                        <li><a href="{{route('tourist.index')}}"><i class="ri-arrow-right-s-fill"></i> All Tourist List</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-creative-commons-nc-line"></i>
                        <span>University</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('university.create')}}"> <i class="ri-arrow-right-s-fill"></i> Add New University</a></li>
                        <li><a href="{{route('university.index')}}"><i class="ri-arrow-right-s-fill"></i> All University List</a></li>
                    </ul>
                </li>


                <li class="menu-title">PLATFORM SETTINGS</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-settings-2-line align-middle me-1"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('manage.settings')}}"> <i class="ri-arrow-right-s-fill"></i> Genarel Settings </a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->