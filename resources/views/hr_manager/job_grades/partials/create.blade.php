@extends('hr_manager.layouts.app')

@section('title')
    <title>Add Job Grade</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Add Job Grade</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.job_grades') }}">Job Grades</a></li>
                <li class="breadcrumb-item active">Add Job Grade</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Job Grades">
        <a href="{{ route('hr_manager.job_grades') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Job Grade</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.job_grades.store') }}" class="row g-3">
                @csrf
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="grade" id="floatingGrade" placeholder="Grade"
                            required>
                        <label for="floatingGrade">Grade</label>
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
