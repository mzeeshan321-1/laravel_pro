@extends('hr_manager.layouts.app')

@section('title')
    <title>Edit Job History</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Job History</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.job_history') }}">Job History</a></li>
                <li class="breadcrumb-item active">Edit Job History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Job History">
        <a href="{{ route('hr_manager.job_history') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Job History</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.job_history.update', $job_history->id) }}" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="user_id" id="Employee" aria-label="Employee Name" required>
                            @if ($users->isNotEmpty())
                                <option value="">--- Select an Employee ---</option>
                                @foreach ($users as $user)
                                    <option {{ $job_history->user_id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            @else
                                <option value="">--- Select an Employee ---</option>
                            @endif
                        </select>
                        <label for="Employee">Employee Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="department_id" id="Departments" aria-label="Departments" required>
                            @if ($departments->isNotEmpty())
                                <option value="">--- Choose Department ---</option>
                                @foreach ($departments as $department)
                                    <option {{ $job_history->department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department_name }}</option>
                                @endforeach
                            @else
                                <option value="">--- Choose Department ---</option>
                            @endif
                        </select>
                        <label for="Departments">Department</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="job_position_id" id="Job" aria-label="Job" required>
                            @if ($jobPositions->isNotEmpty())
                                <option value="" selected>--- Select Job ---</option>
                                @foreach ($jobPositions as $jobPosition)
                                    <option {{ $job_history->job_position_id == $jobPosition->id ? 'selected' : '' }} value="{{ $jobPosition->id }}">{{ $jobPosition->title }}</option>
                                @endforeach
                            @else
                                <option value="" selected>--- Select Job ---</option>
                            @endif
                        </select>
                        <label for="Job">Job</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="job_grade_id" id="jobGrade" aria-label="Job Grade" required>
                            @if ($jobGrades->isNotEmpty())
                                <option value="">--- Select a Job Grade ---</option>
                                @foreach ($jobGrades as $jobGrade)
                                    <option {{ $job_history->job_grade_id == $jobGrade->id ? 'selected' : '' }} value="{{ $jobGrade->id }}">{{ $jobGrade->grade }}</option>
                                @endforeach
                            @else
                                <option value="">--- Select a Job Grade ---</option>
                            @endif
                        </select>
                        <label for="jobGrade">Job Grade</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                            name="start_date" id="start_datepicker" placeholder="Start Date" autocomplete="off"
                            value="{{ old('start_date', $job_history->start_date) }}" required>
                        <label for="start_datepicker">Start Date</label>
                        <div class="invalid-feedback"></div> <!-- Error message -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                            id="end_datepicker" placeholder="End Date" autocomplete="off" value="{{ old('end_date', $job_history->end_date) }}"
                            required>
                        <label for="end_datepicker">End Date</label>
                        <div class="invalid-feedback"></div> <!-- Error message -->
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
            $("#start_datepicker, #end_datepicker").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                onSelect: function() {
                    calculateDays();
                }
            });

            function calculateDays() {
                var startDate = $("#start_datepicker").val();
                var endDate = $("#end_datepicker").val();
                var today = new Date();
                today.setHours(0, 0, 0, 0);

                var startDateInput = $("#start_datepicker");
                var endDateInput = $("#end_datepicker");
                var totalDaysInput = $("#total_days");

                // Reset validation classes and errors
                clearError(startDateInput);
                clearError(endDateInput);
                totalDaysInput.val("");

                // Validate if both dates are selected
                if (!startDate) {
                    showError(startDateInput, "Start Date is required.");
                    return;
                }
                if (!endDate) {
                    showError(endDateInput, "End Date is required.");
                    return;
                }

                // Parse dates
                var start = parseDate(startDate);
                var end = parseDate(endDate);

                // Validate Start Date
                if (!start || isNaN(start.getTime())) {
                    showError(startDateInput, "Invalid Start Date.");
                    return;
                }
                if (start < today) {
                    showError(startDateInput, "Start Date must not be a past date.");
                    return;
                }

                // Validate End Date
                if (!end || isNaN(end.getTime())) {
                    showError(endDateInput, "Invalid End Date.");
                    return;
                }
                if (start > end) {
                    showError(endDateInput, "End Date must be after Start Date.");
                    return;
                }

                // Calculate total leave days
                var diffDays = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24)) + 1;
                totalDaysInput.val(diffDays);

                // Mark fields as valid
                startDateInput.addClass("is-valid");
                endDateInput.addClass("is-valid");
            }

            function parseDate(dateStr) {
                var parts = dateStr.split("-");
                return new Date(parts[2], parts[1] - 1, parts[0]); // Convert dd-mm-yyyy to Date object
            }

            function showError(inputElement, message) {
                inputElement.addClass("is-invalid")
                    .siblings(".invalid-feedback").text(message).show();
                $("#total_days").val("");
            }

            function clearError(inputElement) {
                inputElement.removeClass("is-invalid")
                    .siblings(".invalid-feedback").text("").hide();
            }
        });
    </script>
@endsection