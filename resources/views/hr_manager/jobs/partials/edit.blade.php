@extends('hr_manager.layouts.app')

@section('title')
    <title>Edit Job</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Job</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.jobs') }}">Jobs</a></li>
                <li class="breadcrumb-item active">Edit Job</li>
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
            <form method="post" action="{{ route('hr_manager.jobs.update', $job->id) }}" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="title" id="floatingTitle" value="{{ $job->title }}" placeholder="Job Title"
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
                                    <option {{ $job->department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department_name }}</option>
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
                                    <option {{ $job->position_id == $position->id ? 'selected' : '' }} value="{{ $position->id }}">{{ $position->position }}</option>
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
                        <input type="number" class="form-control" value="{{ old('min_salary', $job->min_salary ?? '') }}" name="min_salary" id="MinSalary"
                            placeholder="Dep. Head" required>
                        <label for="MinSalary">Minimum Salary</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ old('max_salary', $job->max_salary ?? '') }}" name="max_salary" id="MaxSalary"
                            placeholder="Dep. Head" required>
                        <label for="MaxSalary">Maximum Salary</label>
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
