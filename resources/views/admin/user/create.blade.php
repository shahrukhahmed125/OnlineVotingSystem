@extends('masterpage')
@section('title', 'Add User')

@section('css')


@stop
@section('content')

<div class="container-fluid">
    <!-- begin row -->
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Add User</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.home')}}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Dashboard
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Add User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
        </div>
    </div>
    <!-- end row -->
    <!-- begin row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-statistics">
                <form id="addUser-form" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card" id="printable">
                    <div class="card-body">
                        <div class="row row-deck row-cards">
                        <div class="col-lg-8">
                            <div class="row row-cards">
                                <div class="col-12">
                                <div class="card" style="border: none;box-shadow:none;">
                                    <div class="card-body">
                                    <h3 class="card-title">User's Details</h3>
                                    <p class="card-subtitle mb-3">Fill in the user's details.</p>
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">First Name</label>
                                            <input type="text" class="form-control @error('fname') is-invalid @enderror" placeholder="First Name" name="fname" value="{{old('fname')}}" required>
                                            @error('fname')
                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Last Name</label>
                                            <input type="text" class="form-control @error('lname') is-invalid @enderror" placeholder="Last Name" name="lname" value="{{old('lname')}}" required>
                                            @error('lname')
                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label required">Email address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}" required>
                                            @error('email')
                                                <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Here..." name="password" required>
                                            @error('password')
                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Confirm Password</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Re-Password" name="password_confirmation" required>
                                            @error('password_confirmation')
                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Email Verified?</label>
                                            <select class="js-basic-single form-control " name="email_verified_at" required>
                                            <option disabled selected>--Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            </select>
                                            @error('email_verified_at')
                                            <p class="invalid-feedback">{{'*'.$message}}</p>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Gender</label>
                                            <select class="js-basic-single form-control" name="gender">
                                            <option disabled selected>--Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Job title" name="title" value="{{old('title')}}">
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Department</label>
                                            <input type="text" class="form-control" placeholder="Job department" name="department" value="{{old('department')}}">
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address </label>
                                            <textarea rows="3" class="form-control" placeholder="Street Address" name="address">{{old('address')}}</textarea>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row row-cards">
                            <div class="col-12">
                                <div class="card mb-3" style="border: none; border-left: 1px solid #e3e7ea; border-radius: none; box-shadow: none;">
                                <div class="card-body">
                                    <h3 class="card-title">Profile Picture</h3>
                                    <p class="card-subtitle">Images must be in JPG, JPEG, PNG</p>
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-xl me-2 overflow-hidden rounded">
                                            <img 
                                                {{-- src="{{ asset('assets/images/avatars/avatar.png') }}"  --}}
                                                alt="User Avatar" 
                                                id="frame"
                                                class="w-100 h-100 rounded border object-cover"
                                            >
                                        </div>
                                        @error('img')
                                        <p class="invalid-feedback">{{'*'.$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-auto">
                                        <label for="formFile" class="btn">Upload avatar</label>
                                        <input 
                                        class="form-control d-none @error('img') is-invalid @enderror" 
                                        name="img" 
                                        value="{{ old('img') }}" 
                                        type="file" 
                                        id="formFile" 
                                        onchange="preview()" 
                                        accept="image/jpeg, image/png"/>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="card mb-6" style="border: none; border-left: 1px solid #e3e7ea;border-radius: none; box-shadow: none;">
                                <div class="card-body">
                                    <h3 class="card-title">Role & Permissions</h3>
                                    <p class="card-subtitle">Select multiple permissions for any role to give access.</p>
                                    <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label required">User's Role</label>
                                        <select class="js-basic-single form-control" name="role" id="role-select" required>
                                        <option disabled selected>--Select</option>
                                        @foreach ($data as $role)
                                            <option value="{{$role->name}}">{{Str::title($role->name)}}</option>
                                        @endforeach
                                        </select>
                                        @error('role')
                                        <p class="invalid-feedback">{{'*'.$message}}</p>
                                        @enderror
                                    </div>
                                    </div>
                                    <div class="col-12" id="permissions-col" style="display: none;">
                                    <div class="mb-3">
                                        <h3 class="card-title mt-4">Edit & Delete Permissions</h3>
                                        <p class="card-subtitle">User have the ability to edit/delete data.</p>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <label for="edit" class="mb-2"><strong>Edit</strong></label>
                                            <label class="form-check form-switch form-switch-lg">
                                            <input class="form-check-input" type="checkbox" name="edit_permission" id="edit">
                                            <span class="form-check-label form-check-label-on">Enabled</span>
                                            <span class="form-check-label form-check-label-off">Disabled</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="delete" class="mb-2"><strong>Delete</strong></label>
                                            <label class="form-check form-switch form-switch-lg">
                                            <input class="form-check-input" type="checkbox" name="delete_permission" id="delete">
                                            <span class="form-check-label form-check-label-on">Enabled</span>
                                            <span class="form-check-label form-check-label-off">Disabled</span>
                                            </label>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="card" style="border: none; border-left: 1px solid #e3e7ea; border-radius: none; box-shadow: none;">
                                <div class="card-body">
                                    <h3 class="card-title">Other Details</h3>
                                    <div class="mb-3">
                                    <label class="form-label">About Me (bio)</label>
                                    <textarea class="form-control" placeholder="Here can be your description" name="about">{{old('about')}}</textarea>
                                    </div>
                                    <div class="mb-3">
                                    <label class="form-label">City </label>
                                    <select type="text"
                                    class="form-select @error('city') is-invalid @enderror" placeholder="Select City"
                                    name="city" id="select-city" required>
                                    {{-- <option selected disabled>--Select</option> --}}
                                        {{-- @if ($cityData)
                                            @foreach ($cityData as $city)
                                                <option value="{{ $city->id }}">
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        @else
                                            <p>No cities available.</p>
                                        @endif --}}
                                    </select>
                                    </div>
                                    <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                        <label class="form-label">Postal Code </label>
                                        <input type="test" class="form-control" placeholder="ZIP Code" name="postal_code" value="{{old('postal_code')}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="000-000000-00" value="{{old('phone')}}"/>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>      
                        </div>
                        <div class="col-12 mt-5">
                        <div class="card-footer">
                            <div class="btn-list justify-content-end">
                            <input class="btn" type="button" onclick="window.location.href = '{{ route('admin.users.index') }}'" value="Cancel"/>
                            <input type="submit" id="addUser-form-submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {
        $("#party-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("input").removeClass("is-invalid");

            var formData = new FormData(this);

            $('#party-form-btn').prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm"></span> Processing...'
            );

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false, // Important for file upload
                processData: false, // Important for file upload
                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message, "Success", {
                            positionClass: "toast-top-right"
                        });

                        $("#party-form")[0].reset();
                    } else if (response.status === "error") {
                        toastr.error(response.message, "Error", {
                            positionClass: "toast-top-right"
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            var inputField = $("[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.after('<p class="invalid-feedback">' + value[0] + '</p>');
                        });
                    } else {
                        toastr.error("Something went wrong!", "Error", {
                            positionClass: "toast-top-right"
                        });
                    }
                },
                complete: function() {
                    $('#party-form-btn').prop("disabled", false).html('Submit');
                }
            });
        });
    });

</script>    

@stop