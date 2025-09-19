@extends('hr_manager.layouts.app')

@section('title')
    <title>Edit Employee Account</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Edit Employee Account</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.employees') }}">Employees</a></li>
                <li class="breadcrumb-item active">Edit Account</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="text-end mb-2" title="Back to Employees">
        <a href="{{ route('hr_manager.employees') }}" class="btn btn-primary"><i class="ri-arrow-left-s-line"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Employee Account Details</h5>
            <!-- Floating Labels Form -->
            <form method="post" action="{{ route('hr_manager.employees.update', $user->id) }}" class="row g-3"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- {{ dd($user, $user->userInfo) }} --}}
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $user->name ?? '') }}" id="floatingName" placeholder="Your Name" required>
                        <label for="floatingName">Full Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $user->email ?? '') }}" id="floatingEmail" placeholder="Your Email"
                            disabled>
                        <label for="floatingEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password"
                            value="{{ old('password', $user->password ?? '') }}" id="floatingPassword"
                            placeholder="Password" disabled>
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="joining_date"
                            value="{{ old('joining_date', $user->userInfo->joining_date ?? '') }}" id="datepicker"
                            placeholder="Joining Date" autocomplete="off">
                        <label for="datepicker">Joining Date</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" name="status" id="Status" aria-label="Status">
                            <option value="Inactive"
                                {{ old('status', $user->userInfo->status ?? '') == 'Inactive' ? 'selected' : '' }}>
                                Inactive</option>
                            <option value="Active"
                                {{ old('status', $user->userInfo->status ?? '') == 'Active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="On Leave"
                                {{ old('status', $user->userInfo->status ?? '') == 'On Leave' ? 'selected' : '' }}>
                                On Leave</option>
                        </select>
                        <label for="Status">Status</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="designation"
                            value="{{ old('designation', $user->userInfo->designation ?? '') }}" id="floatingDesignation"
                            placeholder="Designation">
                        <label for="floatingDesignation">Designation</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="positions" id="Position" aria-label="Position" required>
                            @if ($positions->isNotEmpty())
                            <option>--- Select Position ---</option>
                                @foreach ($positions as $position)
                                    <option
                                        {{ old('positions', $user->userInfo->position_id ?? '') == $position->id ? 'selected' : '' }}
                                        value="{{ $position->id }}">
                                        {{ $position->position }}
                                    </option>
                                @endforeach
                            @else
                                <option>--- Select Position ---</option>
                            @endif
                        </select>
                        <label for="Position">Position</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="phone"
                            value="{{ old('phone', $user->userInfo->phone ?? '') }}" id="PhoneNumber"
                            placeholder="Phone Number">
                        <label for="PhoneNumber">Phone Number</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="address" placeholder="Address" id="floatingTextarea" style="height: 100px;">{{ old('address', $user->userInfo->address ?? '') }}</textarea>
                        <label for="floatingTextarea">Address</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="departments" id="Departments" aria-label="Departments" required>
                            @if ($departments->isNotEmpty())
                            <option>--- Choose Department ---</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ ($user->userInfo->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            @else
                                <option>--- Choose Department ---</option>
                            @endif
                        </select>
                        <label for="Departments">Department</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="countries" id="country" aria-label="Country" required>
                            @if ($countries->isNotEmpty())
                            <option>--- Select Country ---</option>
                                @foreach ($countries as $country)
                                    <option {{ ($user->userInfo->country_id ?? '') == $country->id ? 'selected' : '' }}
                                        value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            @else
                                <option>--- Select Country ---</option>
                            @endif
                        </select>
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="file" class="form-control" name="image" id="image" title="Image"
                        accept="image/*" value="{{ $user->userInfo->image ?? '' }}">
                </div>
                <div class="col-md-6">
                    @if (!empty($user->userInfo->image))
                        <img src="{{ asset('images/' . ($user->userInfo->image ?? '')) }}" alt="{{ $user->name }}"
                        class="img-thumbnail rounded-circle" id="preview" style="width: 150px; height: 150px;">
                    @else
                    <img src="" alt="Select Image" id="preview" class="img-thumbnail rounded-circle"
                    style="width: 150px; height: 150px; display: none;">
                    @endif
                </div>
                <div class="text-center mt-5 px-3">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </form><!-- End floating Labels Form -->

        </div>
    </div>
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

            // Date Picker
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                });
            });
        });
    </script>
@endsection
