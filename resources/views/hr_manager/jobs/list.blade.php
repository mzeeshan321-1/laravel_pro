@extends('hr_manager.layouts.app')

@section('title')
    <title>Jobs</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Jobs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jobs</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col text-end pb-2" title="Add Jobs">
                <a href="{{ route('hr_manager.jobs.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jobs Detailed List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Job. ID</th>
                                        <th>
                                            <b>T</b>itle
                                        </th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Min Salary</th>
                                        <th>Max Salary</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if ($jobs->isNotEmpty())
                                    <tbody>
                                        @foreach ($jobs as $job)
                                            <tr>
                                                <td>{{ $job->id }}</td>
                                                <td>{{ $job->title }}</td>
                                                <td>{{ $job->department->department_name }}</td>
                                                <td>{{ $job->position->position }}</td>
                                                <td>{{ $job->min_salary }}</td>
                                                <td>{{ $job->max_salary }}</td>
                                                <td>{{ Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ route('hr_manager.jobs.edit', $job->id) }}"
                                                        class="btn btn-light btn-sm text-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    @if (Route::has('hr_manager.jobs.destroy'))
                                                        <form
                                                            action="{{ route('hr_manager.jobs.destroy', $job->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light btn-sm text-danger"
                                                                title="Delete">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="#" class="btn btn-light btn-sm text-danger"
                                                            title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
