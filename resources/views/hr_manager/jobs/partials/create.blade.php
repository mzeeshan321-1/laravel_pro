@extends('hr_manager.layouts.app')

@section('title')
    <title>Add Job</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Add Job</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.jobs') }}">Jobs</a></li>
                <li class="breadcrumb-item active">Add Job</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Jobs">
        <a href="{{ route('hr_manager.jobs') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Job Details</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.jobs.store') }}" class="row g-3">
                @csrf
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="title" id="floatingTitle" placeholder="Title"
                            required>
                        <label for="floatingTitle">Title</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="department_id" id="Departments" aria-label="Departments" required>
                            @if ($departments->isNotEmpty())
                            <option value="">--- Choose Department ---</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
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
                        <select class="form-select" name="position_id" id="Position" aria-label="Position" required>
                            @if ($positions->isNotEmpty())
                            <option value="" selected>--- Select Position ---</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->position }}</option>
                                @endforeach
                            @else
                                <option value="" selected>--- Select Position ---</option>
                            @endif
                        </select>
                        <label for="Position">Position</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="min_salary" id="MinSalary"
                            placeholder="Minimum Salary" value="0" required>
                        <label for="MinSalary">Minimum Salary</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="max_salary" id="MaxSalary"
                            placeholder="Maximum Salary" value="0" required>
                        <label for="MaxSalary">Maximum Salary</label>
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
