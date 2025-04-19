<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\Auth\AgentLoginController;
use App\Http\Controllers\Agent\AgentProfile;
use App\Http\Controllers\Agent\JobInquiryController;
use App\Http\Controllers\Agent\TourTravelController;
use App\Http\Controllers\Agent\StudentController;


Route::get('agent/login', [AgentLoginController::class, 'showLoginForm'])->name('agent.login');
Route::post('agent/login', [AgentLoginController::class, 'login'])->name('agent.login.submit');
Route::post('agent/logout', [AgentLoginController::class, 'logout'])->name('agent.logout');

Route::group(['prefix' => '/agent', 'middleware' => ['auth:agent', 'agent.check.status']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('agent.dashboard');
    Route::get('/profile', [AgentProfile::class, 'index'])->name('agent.profile');
    Route::post('/update-info/{id}', [AgentProfile::class, 'updateInfo'])->name('update.info');
    Route::post('/update-passoword/{id}', [AgentProfile::class, 'updatePassoword'])->name('update.passoword');

    Route::resource('/student', StudentController::class);
    Route::resource('/agent-person', JobInquiryController::class);
    Route::resource('/agent-tourist', TourTravelController::class);
});