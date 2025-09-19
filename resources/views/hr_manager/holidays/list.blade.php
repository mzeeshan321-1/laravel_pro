@extends('hr_manager.layouts.app')

@section('title')
    <title>Holidays</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Holidays</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Holidays</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col text-end pb-2" title="Create Employee Account">
                <a href="{{ route('hr_manager.holidays.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Holidays Detailed list</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Date</th>           
                                        <th scope="col">Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                @if ($holidays->isNotEmpty())
                                    <tbody>
                                        @foreach ($holidays as $holiday)
                                            <tr>
                                                <th scope="row">{{ $holiday->id }}</th>
                                                <td>{{ $holiday->name }}</td>
                                                <td>{{ $holiday->day_of_week }}</td>
                                                <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M') }}</td>
                                                <td>{{ $holiday->type }} Holiday</td>
                                                <td>
                                                    @if ($holiday->status == 'Active')
                                                        <span class="badge bg-success">{{ $holiday->status ?? 'N/A' }}</span>
                                                    @elseif ($holiday->status == 'Inactive')
                                                        <span class="badge bg-danger">{{ $holiday->status ?? 'N/A' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('hr_manager.holidays.edit', $holiday->id) }}"
                                                        class="btn btn-light btn-sm text-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    @if (Route::has('hr_manager.holidays.destroy'))
                                                        <form
                                                            action="{{ route('hr_manager.holidays.destroy', $holiday->id) }}"
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
                        <!-- End Bordered Table -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
