@extends('hr_manager.layouts.app')

@section('title')
    <title>Employee Profile</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Employee Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.employees') }}">Employees</a></li>
                <li class="breadcrumb-item active">Employee Profile </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @php
        $initials = strtoupper(substr($user->name, 0, 1));
        $colors = ['#f94144', '#f3722c', '#f8961e', '#f9c74f', '#90be6d', '#43aa8b', '#577590'];
        $colorIndex = (int) substr(md5($user->id), 0, 1) % count($colors);
        $randomColor = $colors[$colorIndex];
    @endphp
    <div class="text-end mb-2" title="Back to Employees">
        <a href="{{ route('hr_manager.employees') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        @if (($user->userInfo->image ?? '') != null)
                            <img src="{{ asset('images/' . ($user->userInfo->image ?? '')) }}" alt="{{ $user->name }}"
                                class="img-fluid rounded-circle" id="preview">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center"
                                style="width: 60px; height: 60px; font-size: 2.5em; background-color: {{ $randomColor }}; color: #fff;">
                                {{ $initials }}
                            </div>
                        @endif
                        <h2>{{ $user->name }}</h2>
                        <h3>{{ ($user->userInfo->designation ?? '') . ' ' . ($user->userInfo->position->position ?? '') }}
                        </h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->name ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Role</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->role == 3 ? 'Employee' : 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Joining Date</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $user->userInfo->joining_date ?? '' ? \Carbon\Carbon::parse($user->userInfo->joining_date ?? '')->format('d-m-Y') : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Department</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $user->userInfo->department->department_name ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Designation</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->userInfo->designation ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Position</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->userInfo->position->position ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Status</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if (($user->userInfo->status ?? 'Inactive') == 'Active')
                                            <span class="badge bg-success">{{ $user->userInfo->status }}</span>
                                        @elseif (($user->userInfo->status ?? 'Inactive') == 'On Leave')
                                            <span class="badge bg-secondary">{{ $user->userInfo->status }}</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->userInfo->country->name ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->userInfo->address ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->userInfo->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#image').on('change', function(event) {
                const imageInput = event.target;
                const preview = $('#preview');

                if (imageInput.files && imageInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        preview.show();
                    };
                    reader.readAsDataURL(imageInput.files[0]);
                } else {
                    preview.attr('src', '');
                    preview.hide();
                }
            });
        });
    </script>
@endsection
