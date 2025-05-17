<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\DashboardController;
use App\Http\Controllers\AdminController\EmployeesController;
use App\Http\Controllers\AdminController\SalaryController;
use App\Http\Controllers\AdminController\ExpenseController;
use App\Http\Controllers\AdminController\AttendanceController;
use App\Http\Controllers\AdminController\SettingController;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AdminController\IncomeController;
use App\Http\Controllers\AdminController\StudentController;
use App\Http\Controllers\AdminController\CourseController;
use App\Http\Controllers\AdminController\AssignController;
use App\Http\Controllers\AdminController\ScheduleController;
use App\Http\Controllers\AdminController\AgentController;
use App\Http\Controllers\AdminController\CountryController;
use App\Http\Controllers\AdminController\JobTypeController;
use App\Http\Controllers\AdminController\TouristController;
use App\Http\Controllers\AdminController\UniversityController;
use App\Http\Controllers\AdminController\SubjectController;
use App\Http\Controllers\AdminController\JobInquiryController;
use App\Http\Controllers\AdminController\TourTravelController;
use App\Http\Controllers\AdminController\TaskController;
use App\Models\Employees;
use App\Models\JobType;
use App\Models\Subject;
use App\Models\TouristPlace;
use App\Models\University;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Illuminate\Support\Facades\Auth;

Auth::routes();

// login page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get-employee/{id}', function($id) {
    return response()->json(Employees::find($id));
});

Route::get('/get-pay-employee/{id}', function($id) {
    return response()->json(Employees::find($id));
});

Route::get('/get-university/{id}', function($id){
    return response()->json(University::where('country_id', $id)->where('status',1)->get());
});

Route::get('/get-subject/{id}', function($id){
    return response()->json(Subject::where('university_id', $id)->where('status',1)->get());
});

Route::get('/get-job/{id}', function($id){
    return response()->json(JobType::where('country_id', $id)->where('status',1)->get());
});

Route::get('/get-tour-place/{id}', function($id){
    return response()->json(TouristPlace::where('country_id', $id)->where('status',1)->get());
});

//admin dashboard
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'check.status']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::middleware('admin')->name('admin.')->group(function () {
        Route::resource('admin-management', AdminController::class);
        Route::put('admin-status/{id}', [AdminController::class, 'activeStatus']);
    });

    // employees
    Route::middleware('admin')->controller(EmployeesController::class)->group(function(){
        Route::group(['prefix' => '/employees',], function(){
            Route::get('/manage', 'manage')->name('manage.employees');
            Route::get('/add', 'create')->name('add.employees');
            Route::post('/store', 'store')->name('store.employees');
            Route::get('/edit/{id}', 'edit')->name('edit.employees');
            Route::put('/update/{id}', 'update')->name('update.employees');
            Route::delete('/delete/{id}', 'destroy')->name('delete.employees');
        });
    });

    // shedule
    Route::resource('/shedule', ScheduleController::class);

    // expenses
    Route::controller(ExpenseController::class)->group(function(){
        Route::group(['prefix' => '/expenses',], function(){
            Route::get('/manage', 'manage')->name('manage.expenses');
            Route::get('/add', 'create')->name('add.expenses');
            Route::get('/today', 'today')->name('today.expenses');
            Route::get('/month', 'month')->name('month.expenses');
            Route::get('/year', 'year')->name('year.expenses');
            Route::post('/store', 'store')->name('store.expenses');
            Route::get('/edit/{id}', 'edit')->name('edit.expenses');
            Route::get('/show/{id}', 'show')->name('show.expenses');
            Route::put('/update/{id}', 'update')->name('update.expenses');
            Route::delete('/delete/{id}', 'destroy')->name('delete.expenses');

            // others monthly expenses
            Route::get('/monthly-expenses/{month}', 'monthlyExpenses')->name('monthly.expenses');
            Route::get('/monthly-day-expenses', 'monthlyDayExpenses')->name('monthly.day.expenses');
            Route::get('/year-filter', 'yearFilter')->name('year.filter');
        });
    });

    // income
    Route::controller(IncomeController::class)->group(function(){
        Route::group(['prefix' => '/income',], function(){
            Route::get('/manage', 'manage')->name('manage.income');
            Route::get('/add', 'create')->name('add.income');
            Route::get('/today', 'today')->name('today.income');
            Route::get('/month', 'month')->name('month.income');
            Route::get('/year', 'year')->name('year.income');
            Route::post('/store', 'store')->name('store.income');
            Route::get('/edit/{id}', 'edit')->name('edit.income');
            Route::get('/show/{slug}', 'show')->name('show.income');
            Route::put('/update/{id}', 'update')->name('update.income');
            Route::delete('/delete/{id}', 'destroy')->name('delete.income');

            // others monthly expenses
            Route::get('/monthly-income/{month}', 'monthlyIncome')->name('monthly.income');
            Route::get('/monthly-day-income', 'monthlyDayIncome')->name('monthly.day.income');
            Route::get('/year-filter', 'yearFilter')->name('year.filter');
        });
    });

    // Attendance
    Route::controller(AttendanceController::class)->group(function(){
        Route::group(['prefix' => '/attendence',], function(){
            Route::get('/manage/{year?}/{month?}', 'manage')->name('manage.attendance');
            Route::get('/add', 'take')->name('take.attendance');
            Route::get('/add-custom', 'takecustom')->name('custom.attendance');
            Route::post('/store-custom', 'takecustomstore')->name('store.custom.attendance');
            Route::post('/store', 'store')->name('store.attendance');
            Route::get('/edit/{edit_date}', 'edit')->name('edit.attendance');
            Route::get('/details/{employee_id}/{month}/{year}', 'details')->name('details.attendance');

            Route::get('/attendence/month-attendance/{year?}/{month?}', 'month_attendance')->name('month.attendance');
            Route::get('/attendence/monthly-attendances/{month}', 'monthly_attendance')->name('monthly.attendance');

            Route::put('/update/{edit_date}', 'update')->name('update.attendance');
            Route::delete('/delete/{id}', 'destroy')->name('delete.attendance');
        });
    });

    // settings
    Route::controller(SettingController::class)->group(function(){
        Route::group(['prefix' => '/settings',], function(){
            Route::get('/manage', 'manage')->name('manage.settings');
            Route::post('/update', 'update')->name('update.settings');
        });
    });

    // student
    Route::resource('/student-registration', StudentController::class);

    // inquriy
    Route::resource('/inquiry', JobInquiryController::class);

    // tourist
    Route::resource('/tour-travel', TourTravelController::class);

    // course
    Route::resource('/course', CourseController::class);
    Route::put('course-status/{id}', [CourseController::class, 'activeStatus']);

    // assign
    Route::resource('/assign-course', AssignController::class);
    Route::get('/assign-course/{year?}/{month?}', [AssignController::class, 'index'])->name('assign-course.index');

    Route::get('/payemnt/{id}', [AssignController::class, 'payment'])->name('payment');
    Route::post('/payemnt-update', [AssignController::class, 'paymentUpdate'])->name('payment.update');
    Route::get('/get-invoice/{id}', [AssignController::class, 'invoice'])->name('invoice');
    Route::get('/delete-payment/{id}', [AssignController::class, 'delete'])->name('delete.payment');

    // salary
    Route::middleware('admin')->controller(SalaryController::class)->group(function(){
        Route::get('/pay-list/{year?}/{month?}', 'index')->name('pay.list');
        Route::get('pay-custom-salary', 'custom')->name('custom.salary');
        Route::get('pay-salary/{id}/{year?}/{month?}', 'create')->name('pay.salary');
        Route::post('/paid-salary', 'store')->name('paid.salary');
        Route::delete('/delete-salary/{id}', 'delete')->name('delete.salary');
        Route::get('pay-details/{id}/{year?}/{month?}', 'details')->name('pay.details');

        Route::get('edit-salary/{id}', 'edit')->name('edit.salary');

        Route::get('pay-adv', 'adv')->name('pay.adv');
        Route::post('paid-adv', 'paidadv')->name('paid.adv');
        Route::get('paid-adv', 'listadv')->name('list.adv');

        Route::get('edit-adv-salary/{id}', 'editadv')->name('editadv.salary');
        Route::post('update-adv-salary/{id}', 'updateadv')->name('updateadv.salary');
    });

    // agent
    Route::resource('agent', AgentController::class);
    Route::put('agent-status/{id}', [AgentController::class, 'activeStatus'])->name('agent.status');

    // country
    Route::resource('country', CountryController::class);
    Route::put('country-status/{id}', [CountryController::class, 'activeStatus'])->name('country.status');

    // job
    Route::resource('job', JobTypeController::class);
    Route::put('job-status/{id}', [JobTypeController::class, 'activeStatus'])->name('job.status');

    // tourist
    Route::resource('tourist', TouristController::class);
    Route::put('tourist-status/{id}', [TouristController::class, 'activeStatus'])->name('tourist.status');

    // university
    Route::resource('university', UniversityController::class);
    Route::put('university-status/{id}', [UniversityController::class, 'activeStatus'])->name('university.status');

    // subject
    Route::resource('subject', SubjectController::class);
    Route::put('subject-status/{id}', [SubjectController::class, 'activeStatus'])->name('subject.status');

    // task
    Route::resource('task', TaskController::class);
    Route::get('/task/{year?}/{month?}', [TaskController::class, 'manage'])->name('task.index');
    Route::get('/task-today', [TaskController::class, 'today'])->name('task.today');
    Route::get('/task-week', [TaskController::class, 'week'])->name('task.week');

    Route::get('/my-task/{id}', [TaskController::class, 'myTasks'])->name('my.tasks');
    Route::post('/task/update-status', [TaskController::class, 'updateStatus'])->name('task.update.status');

});
