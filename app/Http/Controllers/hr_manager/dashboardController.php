<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\department;
use App\Models\JobPosition;
use App\Models\JobGrade;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Payroll;
use App\Models\Holiday;
use App\Models\UsersInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeesCount = User::where('role', 3)->count();
        $departmentsCount = department::count();
        $jobPositionsCount = JobPosition::count();
        $jobGradesCount = JobGrade::count();
        $leavesCount = Leave::count();
        $payrollCount = Payroll::count();
        $holidaysCount = Holiday::count();
        $leaveTypesCount = LeaveType::count();

        $leaveStatusData = Leave::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pendingLeaves = Leave::where('status', 'pending')->count();
        $approvedLeaves = Leave::where('status', 'approved')->count();
        $rejectedLeaves = Leave::where('status', 'rejected')->count();

        $leavesByMonth = Leave::selectRaw('MONTH(start_date) as month, COUNT(*) as total')
            ->whereYear('start_date', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyLabels = collect(range(1, 12))->map(fn ($month) => Carbon::create(null, $month, 1)->format('M'))->toArray();
        $monthlyLeaves = collect(range(1, 12))->map(fn ($month) => $leavesByMonth[$month] ?? 0)->toArray();

        $departmentsByEmployee = UsersInfo::select('department_id', DB::raw('count(*) as total'))
            ->whereNotNull('department_id')
            ->groupBy('department_id')
            ->with('department')
            ->get();

        $departmentDistributionLabels = $departmentsByEmployee->map(fn ($row) => $row->department?->department_name ?? 'Unassigned')->toArray();
        $departmentDistributionData = $departmentsByEmployee->pluck('total')->toArray();

        $upcomingHolidays = Holiday::where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->take(5)
            ->get();

        $recentLeaves = Leave::with(['user', 'leaveType'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('hr_manager.dashboard', compact(
            'employeesCount',
            'departmentsCount',
            'jobPositionsCount',
            'jobGradesCount',
            'leavesCount',
            'payrollCount',
            'holidaysCount',
            'leaveTypesCount',
            'pendingLeaves',
            'approvedLeaves',
            'rejectedLeaves',
            'leaveStatusData',
            'monthlyLabels',
            'monthlyLeaves',
            'departmentDistributionLabels',
            'departmentDistributionData',
            'upcomingHolidays',
            'recentLeaves'
        ));
    }
}

