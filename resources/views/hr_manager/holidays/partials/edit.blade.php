@extends('hr_manager.layouts.app')

@section('title')
    <title>Holidays</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Holiday</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.holidays') }}">Holidays</a></li>
                <li class="breadcrumb-item active">Edit Holiday</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Employees">
        <a href="{{ route('hr_manager.holidays') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Holiday Details</h5>
            <!-- Floating Labels Form -->
            <form method="post" class="row g-3" action="{{ route('hr_manager.holidays.update', $holiday->id) }}">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $holiday->name ?? 'N/A' }}" id="floatingName" name="name" placeholder="Name" required>
                        <label for="floatingName">Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="day_of_week" id="floatingDayOfWeek" aria-label="Day" required>
                            <option class="text-center" selected value="">-- Choose Holiday's Day --</option>
                            <option {{ $holiday->day_of_week == 'Saturday' ? 'selected' : '' }} value="Saturday">Saturday</option>
                            <option {{ $holiday->day_of_week == 'Sunday' ? 'selected' : '' }} value="Sunday">Sunday</option>
                            <option {{ $holiday->day_of_week == 'Monday' ? 'selected' : '' }} value="Monday">Monday</option>
                            <option {{ $holiday->day_of_week == 'Tuesday' ? 'selected' : '' }} value="Tuesday">Tuesday</option>
                            <option {{ $holiday->day_of_week == 'Wednesday' ? 'selected' : '' }} value="Wednesday">Wednesday</option>
                            <option {{ $holiday->day_of_week == 'Thursday' ? 'selected' : '' }} value="Thursday">Thursday</option>
                            <option {{ $holiday->day_of_week == 'Friday' ? 'selected' : '' }} value="Friday">Friday</option>
                        </select>
                        <label for="floatingDayOfWeek">Day</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $holiday->date ?? 'N/A' }}" name="date" id="datepicker" placeholder="Date" autocomplete="off" required>
                        <label for="datepicker">Date</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea" style="height: 100px;">{{ $holiday->description ?? 'N/A' }}</textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="type" id="floatingType" aria-label="Type" required>
                            <option class="text-center" selected value="">-- Select Holiday Type --</option>
                            <option {{ $holiday->type == 'Gazetted' ? 'selected' : '' }} value="Gazetted">Gazetted Holiday</option>
                            <option {{ $holiday->type == 'Restricted' ? 'selected' : '' }} value="Restricted">Restricted Holiday</option>
                            <option {{ $holiday->type == 'Observance' ? 'selected' : '' }} value="Observance">Observance Holiday</option>
                            <option {{ $holiday->type == 'Seasonal' ? 'selected' : '' }} value="Seasonal">Seasonal Holiday</option>
                            <option {{ $holiday->type == 'Others' ? 'selected' : '' }} value="Others">Others</option>
                        </select>
                        <label for="floatingType">Type</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="status" id="Status" aria-label="Status" required>
                            <option {{ $holiday->status == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                            <option {{ $holiday->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                        </select>
                        <label for="Status">Status</label>
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
            // Date Picker
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                });
            });
        });
    </script>
@endsection

