@extends('hr_manager.layouts.app')

@section('title')
    <title>Departments</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Departments</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Departments</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col text-end pb-2" title="Create Department">
                <a href="{{ route('hr_manager.departments.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Departments Detailed List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Dep. ID</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Dep. Head</th>
                                        <th>Total Employees</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if ($departments->isNotEmpty())
                                    <tbody>
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->department_name }}</td>
                                                <td>{{ $department->department_head }}</td>
                                                <td>{{ $department->total_employees }}</td>
                                                <td>{{ $department->email }}</td>
                                                <td>{{ $department->location }}</td>
                                                <td>
                                                    @if ($department->status == 'Active')
                                                        <span class="badge bg-success">{{ $department->status }}</span>
                                                    @elseif ($department->status == 'Inactive')
                                                        <span class="badge bg-danger">{{ $department->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('hr_manager.departments.edit', $department->id) }}"
                                                        class="btn btn-light btn-sm text-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    @if (Route::has('hr_manager.departments.destroy'))
                                                        <form
                                                            action="{{ route('hr_manager.departments.destroy', $department->id) }}"
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
