@extends('hr_manager.layouts.app')

@section('title')
    <title>HR Profile</title>
@endsection

@section('Page_title')
    <div class="pagetitle">
        <h1>HR Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('hr_manager.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
{{-- {{ dd(Auth::user()->userInfo->image) }} --}}
{{-- {{ dd($randomColor) }} --}}
{{-- {{ dd($initials) }} --}}
    @php
        $initials = strtoupper(substr(Auth::user()->name, 0, 1));
        $colors = ['#f94144', '#f3722c', '#f8961e', '#f9c74f', '#90be6d', '#43aa8b', '#577590'];
        $colorIndex = (int) substr(md5(Auth::user()->id), 0, 1) % count($colors);
        $randomColor = $colors[$colorIndex];
    @endphp
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        @if ((Auth::user()->userInfo->image ?? '') != null)
                            <img src="{{ asset('images/' . (Auth::user()->userInfo->image ?? 'default.png')) }}" alt="Profile"
                                class="rounded-circle">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center"
                                style="width: 100px; font-size: 4em; background-color: {{ $randomColor }}; color: #fff;">
                                {{ $initials }}
                            </div>
                        @endif
                        <h2>{{ Auth::user()->name }}</h2>
                        <h3>{{ (Auth::user()->userInfo->designation ?? '') . ' ' . (Auth::user()->userInfo->position->position ?? '') }}
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
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    Edit Profile
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    Account Settings
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Joining Date</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ isset(Auth::user()->userInfo->joining_date) ? \Carbon\Carbon::parse(Auth::user()->userInfo->joining_date)->format('d-m-Y') : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Role</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->role == 2 ? 'HR Manager' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Department</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ Auth::user()->userInfo->department->department_name ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->userInfo->country->name ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->userInfo->address ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone no.</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->userInfo->phone ?? 'N/A' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Last Login</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ isset(Auth::user()->userInfo->last_login) ? \Carbon\Carbon::parse(Auth::user()->userInfo->last_login)->diffForHumans() : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form method="post" name="editProfile" id="editProfile" autocomplete="off"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            @if (!empty(Auth::user()->userInfo->image))
                                                <img src="{{ asset('images/' . Auth::user()->userInfo->image) }}"
                                                    alt="Profile" id="preview">
                                            @else
                                                <img src="" alt="Select Image" id="preview" class="img-fluid"
                                                    style="display: none;">
                                            @endif
                                            <div class="pt-2">
                                                <input type="file" class="d-none" name="image" id="image"
                                                    accept="image/*">
                                                <label for="image" class="btn btn-primary btn-sm text-white">
                                                    <i class="bi bi-upload"></i>
                                                </label>
                                                <button type="button" id="removeImage"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="name"
                                                value="{{ Auth::user()->name }}" required>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email"
                                                value="{{ Auth::user()->email }}" required>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="datepicker" class="col-md-4 col-lg-3 col-form-label">Joining
                                            Date</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="joining_date" type="text" class="form-control joiningDate"
                                                id="datepicker"
                                                value="{{ Auth::user()->userInfo->joining_date ?? 'N/A' }}">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select class="form-select" name="country" id="country" required
                                                aria-label="Country">
                                                @if ($countries->isNotEmpty())
                                                <option value="">--- Select Country ---</option>
                                                    @foreach ($countries as $country)
                                                        <option
                                                            {{ (Auth::user()->userInfo->country_id ?? '') == $country->id ? 'selected' : '' }}
                                                            value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">--- Select Country ---</option>
                                                @endif
                                            </select>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea class="form-control" name="address" id="address">{{ Auth::user()->userInfo->address ?? '' }}</textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone no.</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="phone"
                                                value="{{ Auth::user()->userInfo->phone ?? 'N/A' }}">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                                <form method="post" name="removeImage" id="removeImage" autocomplete="off">
                                    @csrf
                                </form>
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form method="post" name="resetPassword" id="resetPassword" autocomplete="off">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="CurrentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="CurrentPassword" type="text" class="form-control"
                                                id="CurrentPassword">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="NewPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="NewPassword" type="text" class="form-control"
                                                id="NewPassword">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Re-newPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="Re-newPassword" type="password" class="form-control"
                                                id="Re-newPassword">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

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
            // Date Picker
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                });
            });
            // Change Password
            $('#resetPassword').submit(function(event) {
                event.preventDefault();
                // var token = $('meta[name="csrf-token"]').attr('content');
                $('input[type=submit]').prop('disabled', true);
                $.ajax({
                    url: "{{ route('hr_manager.profile.ChangePassword') }}",
                    type: 'post',
                    // headers: {
                    //     'X-CSRF-TOKEN': token
                    // },
                    data: $(this).serializeArray(),
                    datatype: "json",
                    success: function(response) {
                        $('input[type=submit]').prop('disabled', false);

                        function handleErrorMessage(field, error) {
                            if (error) {
                                $(field).addClass('is-invalid')
                                    .siblings('small').addClass('invalid-Credentials').html(
                                        error);
                            } else {
                                $(field).removeClass('is-invalid')
                                    .siblings('small').removeClass('invalid-Credentials').html(
                                        '');
                            }
                        }
                        if (response['status'] == true) {
                            window.location.href = "{{ route('hr_manager.profile.edit') }}";
                            var fields = ['#CurrentPassword', '#NewPassword',
                                '#Re-newPassword'
                            ];
                            fields.forEach(function(field) {
                                handleErrorMessage(field, null);
                            });
                        } else {
                            var errors = response.error;
                            var fields = ['#CurrentPassword', '#NewPassword',
                                '#Re-newPassword'
                            ];
                            fields.forEach(function(field) {
                                handleErrorMessage(field, errors[field.replace('#',
                                    '')]);
                            });
                        }
                    },
                    error: function(jQXHR, exception) {
                        console.log('something went wrong');
                    }
                });
            });
            // Remove Profile Image
            $('#removeImage').on('click', function() {
                $('#editProfile').append('<input type="hidden" name="remove_image" value="1">');
                $('#editProfile').submit();
            });
            // Change User Information
            $('#editProfile').submit(function(event) {
                event.preventDefault();
                // var token = $('meta[name="csrf-token"]').attr('content');
                $('input[type=submit]').prop('disabled', true);
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('hr_manager.profile.update') }}",
                    type: 'post',
                    // headers: {
                    //     'X-CSRF-TOKEN': token
                    // },
                    data: formData,
                    datatype: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('input[type=submit]').prop('disabled', false);

                        function handleErrorMessage(field, error) {
                            if (error) {
                                $(field).addClass('is-invalid')
                                    .siblings('small').addClass('invalid-Credentials').html(
                                        error);
                            } else {
                                $(field).removeClass('is-invalid')
                                    .siblings('small').removeClass('invalid-Credentials').html(
                                        '');
                            }
                        }
                        if (response['status'] == true) {
                            window.location.href = "{{ route('hr_manager.profile.edit') }}";
                            var fields = ['.image', '#name', '#email', '#phone', '#address',
                                '.joiningDate', '#country', '#removeImage'
                            ];
                            fields.forEach(function(field) {
                                handleErrorMessage(field, null);
                            });
                        } else {
                            var errors = response.error;
                            var fields = ['.image', '#name', '#email', '#phone', '#address',
                                '.joiningDate', '#country', '#removeImage'
                            ];
                            fields.forEach(function(field) {
                                handleErrorMessage(field, errors[field.replace(/[#.]/,
                                    '')]);
                            });
                        }
                    },
                    error: function(jQXHR, exception) {
                        console.log('something went wrong');
                    }
                });
            });
        });
    </script>
@endsection

