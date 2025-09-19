@extends('hr_manager.layouts.app')

@section('title')
    <title>Leave Requests</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Leave Requests</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Leave Requests</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Leaves Detailed list</h5>
                        <!-- Dynamic Tabs -->
                        <ul class="nav nav-pills justify-content-center mb-3" id="leaveTabs">
                            <li class="nav-item">
                                <a class="nav-link tab-link active" 
                                   id="pending-tab" data-bs-toggle="pill" href="#pending" role="tab">
                                    <i class="ri-time-line"></i> Pending
                                    <span class="badge count-badge" id="pending-count">
                                        {{ $leaves->where('status', 'Pending')->count() }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-link" 
                                   id="approved-tab" data-bs-toggle="pill" href="#approved" role="tab">
                                    <i class="ri-check-line"></i> Approved
                                    <span class="badge count-badge" id="approved-count">
                                        {{ $leaves->where('status', 'Approved')->count() }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-link"
                                   id="rejected-tab" data-bs-toggle="pill" href="#rejected" role="tab">
                                    <i class="ri-close-line"></i> Rejected
                                    <span class="badge count-badge" id="rejected-count">
                                        {{ $leaves->where('status', 'Rejected')->count() }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="leaveTabsContent">

                            <!-- Pending Leaves -->
                            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center text-nowrap">
                                        <thead class="table-warning text-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Total Days</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leaves->where('status', 'Pending') as $leave)
                                                <tr>
                                                    <td>{{ $leave->id }}</td>
                                                    <td>{{ $leave->user->name }}</td>
                                                    <td>{{ $leave->leaveType->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                                    <td>{{ $leave->total_days }}</td>
                                                    <td>{{ $leave->reason }}</td>
                                                    <td><span class="badge bg-warning">{{ $leave->status }}</span></td>
                                                    <td>
                                                        <a href="{{ route('hr_manager.leaves.approveLeave', $leave->id) }}" class="btn btn-success btn-sm" title="Approve">
                                                            <i class="ri-check-line"></i>
                                                        </a>
                                                        <a href="{{ route('hr_manager.leaves.rejectLeave', $leave->id) }}" class="btn btn-danger btn-sm" title="Reject">
                                                            <i class="ri-close-line"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Approved Leaves -->
                            <div class="tab-pane fade" id="approved" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center text-nowrap">
                                        <thead class="table-success text-white">
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Total Days</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leaves->where('status', 'Approved') as $leave)
                                                <tr>
                                                    <td>{{ $leave->id }}</td>
                                                    <td>{{ $leave->user->name }}</td>
                                                    <td>{{ $leave->leaveType->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                                    <td>{{ $leave->total_days }}</td>
                                                    <td>{{ $leave->reason }}</td>
                                                    <td><span class="badge bg-success">{{ $leave->status }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Rejected Leaves -->
                            <div class="tab-pane fade" id="rejected" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center text-nowrap">
                                        <thead class="table-danger text-white">
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Total Days</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leaves->where('status', 'Rejected') as $leave)
                                                <tr>
                                                    <td>{{ $leave->id }}</td>
                                                    <td>{{ $leave->user->name }}</td>
                                                    <td>{{ $leave->leaveType->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                                    <td>{{ $leave->total_days }}</td>
                                                    <td>{{ $leave->reason }}</td>
                                                    <td><span class="badge bg-danger">{{ $leave->status }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div> <!-- End Tab Content -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Get the URL query string
            let urlParams = new URLSearchParams(window.location.search);
            let status = urlParams.get('status');

            // Set the active tab based on the query string
            if (status == 'Pending') {
                $('#pending-tab').addClass('active bg-warning text-light');
                $('#pending').addClass('show active');
            } else if (status == 'Approved') {
                $('#approved-tab').addClass('active bg-success text-light');
                $('#approved').addClass('show active');
            } else if (status == 'Rejected') {
                $('#rejected-tab').addClass('active bg-danger text-light');
                $('#rejected').addClass('show active');
            }
        });
    </script>
@endsection


