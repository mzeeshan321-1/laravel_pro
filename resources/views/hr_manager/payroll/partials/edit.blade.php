@extends('hr_manager.layouts.app')

@section('title')
    <title>Edit Payroll</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Payroll</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.payroll') }}">Payroll</a></li>
                <li class="breadcrumb-item active">Edit Payroll</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Payroll">
        <a href="{{ route('hr_manager.payroll') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Payroll</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.payroll.update', $payroll->id) }}" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="user_id" id="user_id" aria-label="Employee Name"
                            required>
                            @if ($employees->isNotEmpty())
                            <option class="text-center" selected value="">-- Select an Employee --</option>
                                @foreach ($employees as $employee)
                                    <option {{ $payroll->user_id == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            @else
                                <option class="text-center" value="">-- Select an Employee --</option>
                            @endif
                        </select>
                        <label for="leave_type_id">Employee Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->num_of_day_work }}" name="num_of_day_work" id="numOfDayWork"
                            placeholder="Number of Day Worked" required>
                        <label for="numOfDayWork">Number of Days Worked</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->bonus }}" name="bonus" id="bonus"
                            placeholder="Bonus" required>
                        <label for="bonus">Bonus</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->overtime }}" name="overtime" id="overtime"
                            placeholder="Overtime" required>
                        <label for="overtime">Overtime</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->gross_salary }}" name="gross_salary" id="grossSalary"
                            placeholder="Gross Salary" required>
                        <label for="grossSalary">Gross Salary</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->cash_advance }}" name="cash_advance" id="cashAdvance"
                            placeholder="Cash Advance" required>
                        <label for="cashAdvance">Cash Advance</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->late_hours }}" name="late_hours" id="lateHours"
                            placeholder="Late Hours">
                        <label for="lateHours">Late Hours</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->absent_days }}" name="absent_days" id="absentDays"
                            placeholder="Absent Days" required>
                        <label for="absentDays">Absent Days</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->total_deduction }}" name="total_deduction" id="totalDeduction"
                            placeholder="Total Deduction" required>
                        <label for="totalDeduction">Total Deduction</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $payroll->netpay }}" name="netpay" id="netPay"
                            placeholder="Net Pay" required>
                        <label for="netPay">Net Pay</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $payroll->payroll_month }}" name="payroll_month" id="payrollMonth"
                            placeholder="Payroll Month" required autocomplete="off">
                        <label for="payrollMonth">Payroll Month</label>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <input type="reset" value="Reset" class="btn btn-danger">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </form><!-- End floating Labels Form -->

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#payrollMonth").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,            
            });
        });
    </script>
@endsection