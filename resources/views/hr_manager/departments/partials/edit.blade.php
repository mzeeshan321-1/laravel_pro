@extends('hr_manager.layouts.app')

@section('title')
    <title>Edit Department</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Department</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.departments') }}">Department</a></li>
                <li class="breadcrumb-item active">Edit Department</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Employees">
        <a href="{{ route('hr_manager.departments') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Department Details</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.departments.update', $department->id) }}" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="department_name" id="floatingName" placeholder="Dep. Name"
                           value="{{ ($department->department_name ?? 'N/A') }}" required>
                        <label for="floatingName">Department Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="department_head" id="DepartmentHead"
                            placeholder="Dep. Head" value="{{ ($department->department_head ?? 'N/A') }}">
                        <label for="DepartmentHead">Department Head</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" id="floatingEmail"
                            placeholder="Your Email" value="{{ ($department->email ?? 'N/A') }}" required>
                        <label for="floatingEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="contact_info" id="ContactInfo"
                            placeholder="Contact Info" value="{{ ($department->contact_info ?? 'N/A') }}">
                        <label for="ContactInfo">Contact Info</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="total_employees" id="totalEmployees"
                            placeholder="Total Employees" value="{{ ($department->total_employees ?? '0') }}">
                        <label for="totalEmployees">Total Employees</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" name="status" id="Status" aria-label="Status">
                            <option {{ ($department->status ?? 'N/A') == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                            <option {{ ($department->status ?? 'N/A') == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                        </select>
                        <label for="Status">Status</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="location" placeholder="Location" id="floatingLocation" style="height: 100px;">{{ ($department->location ?? 'N/A') }}</textarea>
                        <label for="floatingLocation">Location</label>
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
