@extends('hr_manager.layouts.app')

@section('title')
    <title>Employees</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Employees</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col text-end pb-2" title="Create Employee Account">
                <a href="{{ route('hr_manager.employees.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employees Detailed List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Emp. ID</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Joining</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                {{-- {{ dd($users) }} --}}
                                @if ($users->isNotEmpty())
                                <tbody>

                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->userInfo->department->department_name ?? 'N/A' }}</td>
                                        <td>{{ $user->userInfo->position->position ?? 'N/A' }}</td>
                                        <td>
                                            {{ ($user->userInfo->joining_date ?? '') ? \Carbon\Carbon::parse(($user->userInfo->joining_date ?? ''))->diffForHumans() : 'N/A' }}
                                        </td>
                                        <td>
                                            @if (($user->userInfo->status ?? 'Inactive') == 'Active')
                                                <span class="badge bg-success">{{ $user->userInfo->status }}</span>
                                            @elseif (($user->userInfo->status ?? 'Inactive') == 'On Leave')
                                                <span class="badge bg-secondary">{{ $user->userInfo->status }}</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('hr_manager.employees.e-profile', $user->id) }}" class="btn btn-light btn-sm text-secondary" title="More">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('hr_manager.employees.edit', $user->id) }}" class="btn btn-light btn-sm text-primary" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            @if (Route::has('hr_manager.employees.destroy'))
                                            <form action="{{ route('hr_manager.employees.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm text-danger" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                            @else
                                            <a href="#" class="btn btn-light btn-sm text-danger" title="Delete">
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
