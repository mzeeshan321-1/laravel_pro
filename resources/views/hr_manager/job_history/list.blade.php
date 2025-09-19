@extends('hr_manager.layouts.app')

@section('title')
    <title>Job History</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Job History</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Job History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col text-end pb-2" title="Add Job History">
                <a href="{{ route('hr_manager.job_history.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job History Detailed List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>
                                            <b>E</b>mployee
                                        </th>
                                        <th>Job</th>
                                        <th>Department</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if ($jobHistories->isNotEmpty())
                                    <tbody>
                                        @foreach ($jobHistories as $jobHistory)
                                            <tr>
                                                <td>{{ $jobHistory->id }}</td>
                                                <td>{{ $jobHistory->user->name }}</td>
                                                <td>{{ $jobHistory->jobPosition->title }}</td>
                                                <td>{{ $jobHistory->department->department_name }}</td>
                                                <td>{{ Carbon\Carbon::parse($jobHistory->start_date)->format('d M Y') }}</td>
                                                <td>{{ Carbon\Carbon::parse($jobHistory->end_date)->format('d M Y') }}</td>
                                                <td>{{ Carbon\Carbon::parse($jobHistory->created_at)->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ route('hr_manager.job_history.edit', $jobHistory->id) }}"
                                                        class="btn btn-light btn-sm text-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    @if (Route::has('hr_manager.job_history.destroy'))
                                                        <form
                                                            action="{{ route('hr_manager.job_history.destroy', $jobHistory->id) }}"
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
