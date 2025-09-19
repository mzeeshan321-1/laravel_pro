@extends('hr_manager.layouts.app')

@section('title')
    <title>Holidays</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Create Holiday</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.holidays') }}">Holidays</a></li>
                <li class="breadcrumb-item active">Create Holiday</li>
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
            <form method="post" class="row g-3" action="{{ route('hr_manager.holidays.store')}}">
                @csrf
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingName" name="name" placeholder="Name" required>
                        <label for="floatingName">Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="day_of_week" id="floatingDayOfWeek" aria-label="Day" required>
                            <option class="text-center" selected value="">-- Choose Holiday's Day --</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                        <label for="floatingDayOfWeek">Day</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="date" id="datepicker" placeholder="Date" autocomplete="off" required>
                        <label for="datepicker">Date</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea" style="height: 100px;"></textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="type" id="floatingType" aria-label="Type" required>
                            <option class="text-center" selected value="">-- Select Holiday Type --</option>
                            <option value="Gazetted">Gazetted Holiday</option>
                            <option value="Restricted">Restricted Holiday</option>
                            <option value="Observance">Observance Holiday</option>
                            <option value="Seasonal">Seasonal Holiday</option>
                            <option value="Others">Others</option>
                        </select>
                        <label for="floatingType">Type</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="status" id="Status" aria-label="Status" required>
                            <option selected value="Inactive">Inactive</option>
                            <option value="Active">Active</option>
                        </select>
                        <label for="Status">Status</label>
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

