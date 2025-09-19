@extends('employee.layouts.app')

@section('title')
    <title>Leaves</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Leaves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section>
        @include('employee.leaves.partials.leave_info')
        <div class="row">
            <div class="col text-end pb-2" title="Apply for Leave">
                <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- {{ dd($leaves) }} --}}
                        <h5 class="card-title">Leaves Detailed list</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Leave Type</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">End Date</th>
                                        <th scope="col">Total Days</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                @if ($leaves->isNotEmpty())
                                    <tbody>
                                        @foreach ($leaves as $leave)
                                            <tr>
                                                <th scope="row">{{ $leave->id ?? '' }}</th>
                                                <td>{{ $leave->leaveType->name ?? '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($leave->start_date ?? '')->format('d M Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($leave->end_date ?? '')->format('d M Y') }}
                                                </td>
                                                <td>{{ $leave->total_days ?? '' }}</td>
                                                <td>{{ $leave->reason ?? '' }}</td>
                                                <td>
                                                    @if ($leave->status == 'Pending')
                                                        <span class="badge bg-warning">{{ $leave->status ?? 'N/A' }}</span>
                                                    @elseif ($leave->status == 'Approved')
                                                        <span class="badge bg-success">{{ $leave->status ?? 'N/A' }}</span>
                                                    @elseif ($leave->status == 'Rejected')
                                                        <span class="badge bg-danger">{{ $leave->status ?? 'N/A' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($leave->status == 'Pending')
                                                        <a href="{{ route('employee.leaves.edit', $leave->id) }}"
                                                            class="btn btn-light btn-sm text-primary" title="Edit">
                                                            <i class="ri-edit-line"></i>
                                                        </a>
                                                        @if (Route::has('employee.leaves.destroy'))
                                                            <form
                                                                action="{{ route('employee.leaves.destroy', $leave->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-light btn-sm text-danger" title="Delete">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="#" class="btn btn-light btn-sm text-danger"
                                                                title="Delete">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </a>
                                                        @endif
                                                    @elseif ($leave->status == 'Rejected')
                                                        @if (Route::has('employee.leaves.destroy'))
                                                            <form
                                                                action="{{ route('employee.leaves.destroy', $leave->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-light btn-sm text-danger" title="Delete">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="#" class="btn btn-light btn-sm text-danger"
                                                                title="Delete">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </a>
                                                        @endif
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
