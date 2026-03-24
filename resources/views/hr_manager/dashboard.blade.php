@extends('hr_manager.layouts.app')

@section('title')
  <title>HR Dashboard</title>
@endsection

@section('Page_title')
<div class="pagetitle">
    <h1>Welcome Manager {{ Auth::user()->name }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('content')
<div class="row gy-3">
    <div class="col-lg-3 col-md-6">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h6 class="card-title">Total Employees</h6>
                <h2>{{ number_format($employeesCount) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-success h-100">
            <div class="card-body">
                <h6 class="card-title">Departments</h6>
                <h2>{{ number_format($departmentsCount) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-warning h-100">
            <div class="card-body">
                <h6 class="card-title">Job Positions</h6>
                <h2>{{ number_format($jobPositionsCount) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-danger h-100">
            <div class="card-body">
                <h6 class="card-title">Job Grades</h6>
                <h2>{{ number_format($jobGradesCount) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row gy-3 mt-3">
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Leaves</h6>
                <h2>{{ number_format($leavesCount) }}</h2>
                <small>Pending: {{ number_format($pendingLeaves) }}, Approved: {{ number_format($approvedLeaves) }}, Rejected: {{ number_format($rejectedLeaves) }}</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Payroll Entries</h6>
                <h2>{{ number_format($payrollCount) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Holidays</h6>
                <h2>{{ number_format($holidaysCount) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Leave Types</h6>
                <h2>{{ number_format($leaveTypesCount) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Upcoming Holidays</h5>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Name</th><th>Date</th><th>Type</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($upcomingHolidays as $holiday)
                        <tr>
                            <td>{{ $holiday->name }}</td>
                            <td>{{ Carbon\Carbon::parse($holiday->date)->format('M d, Y') }}</td>
                            <td>{{ $holiday->type }}</td>
                            <td>{{ $holiday->status }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No upcoming holidays</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Latest Leave Requests</h5>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>User</th><th>Type</th><th>Dates</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($recentLeaves as $leave)
                        <tr>
                            <td>{{ $leave->user?->name ?? 'N/A' }}</td>
                            <td>{{ $leave->leaveType?->name ?? 'N/A' }}</td>
                            <td>{{ Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ Carbon\Carbon::parse($leave->end_date)->format('M d') }}</td>
                            <td>{{ ucfirst($leave->status) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4">No recent leave requests</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection