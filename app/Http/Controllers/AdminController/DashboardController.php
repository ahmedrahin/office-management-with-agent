<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Income;

class DashboardController extends Controller
{
   public function index()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month; // Numeric month (2 for February)
        $lastWeek = Carbon::now()->subWeek()->weekOfYear;
        $lastMonth = Carbon::now()->subMonth()->month; // Numeric month
        
        // Total income for this year
        $yearIncome = Income::where('year', $currentYear)->sum('amn');
        
        // Total income for last week
        $lastWeekIncome = Income::whereRaw("WEEK(STR_TO_DATE(date, '%d %b, %Y'), 1) = ?", [$lastWeek])
            ->where('year', $currentYear)
            ->sum('amn');
        
        // Total income for last month
        $lastMonthIncome = Income::where('month', $lastMonth)
            ->where('year', $currentYear)
            ->sum('amn');
        
        // Fetch data for the chart (grouped by month)
        $monthlyIncome = Income::where('year', $currentYear)
            ->selectRaw('month, SUM(amn) as total')
            ->groupBy('month')
            ->pluck('total', 'month');
        
        return view('backend.pages.dashboard', compact('yearIncome', 'lastWeekIncome', 'lastMonthIncome', 'monthlyIncome'));
    }

}
