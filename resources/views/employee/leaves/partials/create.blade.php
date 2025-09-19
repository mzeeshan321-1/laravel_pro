@extends('employee.layouts.app')

@section('title')
    <title>Request Leave</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Request Leave</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('employee.leaves') }}">Leaves</a></li>
                <li class="breadcrumb-item active">Request Leave</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @include('employee.leaves.partials.leave_info')
    <div class="text-end mb-2" title="Back to Employees">
        <a href="{{ route('employee.leaves') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Leave Details</h5>
            <!-- Floating Labels Form -->
            <form method="post" class="row g-3" action="{{ route('employee.leaves.store') }}">
                @csrf
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="leave_type_id" id="leave_type_id" aria-label="Leave Type"
                            required>
                            <option class="text-center" selected value="">-- Select Leave Type --</option>
                            @if ($leave_types->isNotEmpty())
                                @foreach ($leave_types as $leave_type)
                                    <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                @endforeach
                            @else
                                <option class="text-center" value="">-- Select Leave Type --</option>
                            @endif
                        </select>
                        <label for="leave_type_id">Leave Type</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                            name="start_date" id="start_datepicker" placeholder="Start Date" autocomplete="off"
                            value="{{ old('start_date') }}" required>
                        <label for="start_datepicker">Start Date</label>
                        <div class="invalid-feedback"></div> <!-- Error message -->
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                            id="end_datepicker" placeholder="End Date" autocomplete="off" value="{{ old('end_date') }}"
                            required>
                        <label for="end_datepicker">End Date</label>
                        <div class="invalid-feedback"></div> <!-- Error message -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="total_days" id="total_days"
                            placeholder="Total Days" autocomplete="off" readonly>
                        <label for="total_days">Total Days</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="reason" placeholder="Reason" id="reason" style="height: 100px;" required></textarea>
                        <label for="reason">Reason</label>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <input type="reset" value="Reset" class="btn btn-danger">
                    <input type="submit" value="Submit" class="btn btn-primary">
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
