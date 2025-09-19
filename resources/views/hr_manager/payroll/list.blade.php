@extends('hr_manager.layouts.app')

@section('title')
    <title>Payroll</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Payroll</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Payroll</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col text-end pb-2" title="Add Payroll">
                <a href="{{ route('hr_manager.payroll.create') }}" class="btn btn-primary">
                    <i class="ri-add-fill"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payroll Detailed List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>
                                            <b>Employee Name</b>
                                        </th>
                                        <th>Pay Month</th>
                                        <th>Days Worked</th>
                                        <th>Late Hours</th>
                                        <th>Absents</th>
                                        <th>Net Pay</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if ($payrolls->isNotEmpty())
                                    <tbody>
                                        @foreach ($payrolls as $payroll)
                                            <tr>
                                                <td>{{ $payroll->id }}</td>
                                                <td>{{ $payroll->user->name }}</td>
                                                <td>{{ $payroll->payroll_month }}</td>
                                                <td>{{ $payroll->num_of_day_work }}</td>
                                                <td>{{ $payroll->late_hours }}</td>
                                                <td>{{ $payroll->absent_days }}</td>
                                                <td>{{ $payroll->netpay }}</td>
                                                <td>
                                                    <a href="{{ route('hr_manager.payroll.edit', $payroll->id) }}"
                                                        class="btn btn-light btn-sm text-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    @if (Route::has('hr_manager.payroll.destroy'))
                                                        <form
                                                            action="{{ route('hr_manager.payroll.destroy', $payroll->id) }}"
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