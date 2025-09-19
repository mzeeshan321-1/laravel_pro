@extends('hr_manager.layouts.app')

@section('title')
    <title>Create Employee Account</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>Create Employee Account</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.employees') }}">Employees</a></li>
                <li class="breadcrumb-item active">Create Account</li>
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
            <form method="post" action="{{ route('hr_manager.employees.store') }}" class="row g-3"
                enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="name" id="floatingName" placeholder="Your Name"
                            required>
                        <label for="floatingName">Full Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" id="floatingEmail"
                            placeholder="Your Email" required>
                        <label for="floatingEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password" id="floatingPassword"
                            placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="joining_date" id="datepicker"
                            placeholder="Joining Date" required autocomplete="off">
                        <label for="datepicker">Joining Date</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" name="status" id="Status" aria-label="Status" required>
                            <option selected value="Inactive">Inactive</option>
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                        <label for="Status">Status</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="" class="form-control" name="designation" id="floatingDesignation"
                            placeholder="Designation" required>
                        <label for="floatingDesignation">Designation</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="positions" id="Position" aria-label="Position">
                            @if ($positions->isNotEmpty())
                            <option value="" selected>--- Select Position ---</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->position }}</option>
                            @endforeach
                            @else
                            <option value="" selected>--- Select Position ---</option>
                            @endif
                        </select>
                        <label for="Position">Position</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="phone" id="PhoneNumber"
                            placeholder="Phone Number" required>
                        <label for="PhoneNumber">Phone Number</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="address" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                        <label for="floatingTextarea">Address</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="departments" id="Departments" aria-label="Departments">
                            @if ($departments->isNotEmpty())
                            <option value="">--- Choose Department ---</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                            @else
                            <option value="">--- Choose Department ---</option>
                            @endif
                        </select>
                        <label for="Departments">Department</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="countries" id="country" aria-label="Country">
                            @if ($countries->isNotEmpty())
                            <option selected>--- Select Country ---</option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                            @else
                            <option selected>--- Select Country ---</option>
                            @endif
                        </select>
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="col-md-6">
                        <input type="file" name="image" class="form-control" id="image" title="Image"
                            accept="image/*">
                </div>
                <div class="col-md-6">
                    <img src="" alt="Select Image" id="preview" class="img-thumbnail rounded-circle"
                        style="width: 150px; height: 150px; display: none;">
                </div>
                <div class="text-center mt-3 px-3">
                    <input type="submit" value="Submit" class="btn btn-primary">
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
