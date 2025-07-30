@extends('masterpage')
@section('title', 'Add User')

@section('css')

<style>
    #party-select-wrapper{
        overflow: hidden;
        transition: max-height 0.3s ease;
        max-height: 0;
    }
</style>

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
                                    <a href="{{ route('admin.home') }}"><i class="ti ti-home"></i></a>
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
                <div class="">
                    <form id="addUser-form" action="{{ route('admin.users.store') }}" method="post"
                        enctype="multipart/form-data">
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
                                                                    <label class="form-label required">First Name*</label>
                                                                    <input type="text"
                                                                        class="form-control @error('fname') is-invalid @enderror"
                                                                        placeholder="First Name" name="fname"
                                                                        value="{{ old('fname') }}" required>
                                                                    @error('fname')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Last Name*</label>
                                                                    <input type="text"
                                                                        class="form-control @error('lname') is-invalid @enderror"
                                                                        placeholder="Last Name" name="lname"
                                                                        value="{{ old('lname') }}" required>
                                                                    @error('lname')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">National ID (CNIC)*</label>
                                                                    <input type="cnic"
                                                                        class="form-control @error('cnic') is-invalid @enderror"
                                                                        placeholder="CINC" name="cnic"
                                                                        value="{{ old('cnic') }}" required>
                                                                    @error('cnic')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Email
                                                                        Address*</label>
                                                                    <input type="email"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        placeholder="Email" name="email"
                                                                        value="{{ old('email') }}" required>
                                                                    @error('email')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Email
                                                                        Verified?</label>
                                                                    <select class="js-basic-single form-control "
                                                                        name="email_verified_at" required>
                                                                        <option disabled selected>--Select</option>
                                                                        <option value="Yes">Yes</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                    @error('email_verified_at')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Gender</label>
                                                                    <select class="js-basic-single form-control"
                                                                        name="gender">
                                                                        <option disabled selected>--Select</option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                        <option value="others">Others</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">National Assembly
                                                                        (NA)</label>
                                                                    <select class="js-basic-single form-control "
                                                                        name="na_constituency_id">
                                                                        <option disabled selected>--Select</option>
                                                                        @if ($assemblies)
                                                                            @foreach ($assemblies as $item)
                                                                                @if ($item->type == 'NA')
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ ucwords($item->name) }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Assembly Found
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                    @error('na_constituency_id')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Provincial Assembly
                                                                        (PA)</label>
                                                                    <select class="js-basic-single form-control"
                                                                        name="pa_constituency_id">
                                                                        <option disabled selected>--Select</option>
                                                                        @if ($assemblies)
                                                                            @foreach ($assemblies as $item)
                                                                                @if ($item->type == 'PA')
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ ucwords($item->name) }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Assembly Found
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                    @error('pa_constituency_id')
                                                                        <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Title</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Job title" name="title"
                                                                        value="{{ old('title') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Department</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Job department" name="department"
                                                                        value="{{ old('department') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Address </label>
                                                                    <textarea rows="3" class="form-control" placeholder="Street Address" name="address">{{ old('address') }}</textarea>
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
                                                <div class="card mb-3"
                                                    style="border: none; border-left: 1px solid #e3e7ea; border-radius: none; box-shadow: none;">
                                                    <div class="card-body">
                                                        <h3 class="card-title">Profile Picture</h3>
                                                        <p class="card-subtitle mb-3">Images must be in JPG, JPEG, PNG</p>
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <div class="avatar avatar-xl overflow-hidden rounded-circle"
                                                                    style="width: 80px; height: 80px;">
                                                                    <img src="{{ asset('assets/img/avtar/11.png') }}"
                                                                        alt="User Avatar" id="frame"
                                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                                                </div>
                                                                @error('img')
                                                                    <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                                @enderror
                                                            </div>

                                                            <div class="col-auto">
                                                                <label for="formFile"
                                                                    class="btn btn-outline-primary mb-0">Upload
                                                                    avatar</label>
                                                                <input
                                                                    class="form-control d-none @error('img') is-invalid @enderror"
                                                                    name="img" value="{{ old('img') }}"
                                                                    type="file" id="formFile" onchange="preview()"
                                                                    accept="image/jpeg, image/png" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mb-6"
                                                    style="border: none; border-left: 1px solid #e3e7ea;border-radius: none; box-shadow: none;">
                                                    <div class="card-body">
                                                        <h3 class="card-title">Role & Permissions</h3>
                                                        <p class="card-subtitle mb-3">Select multiple permissions for any
                                                            role to give access.</p>
                                                        <div class="mb-3">
                                                            <label class="form-label required">User's Role*</label>
                                                            <select class="js-basic-single form-control" name="role"
                                                                id="role-select" required>
                                                                <option disabled selected>--Select</option>
                                                                @foreach ($data as $role)
                                                                    <option value="{{ $role->name }}">
                                                                        {{ Str::title($role->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('role')
                                                                <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3" id="party-select-wrapper"
                                                            style="display: none;">
                                                            <label class="form-label required">Political Party*</label>
                                                            <select class="js-basic-single form-control"
                                                                name="political_party_id" id="party-select">
                                                                <option disabled selected>--Select</option>
                                                                @if (isset($parties) && count($parties))
                                                                    @foreach ($parties as $party)
                                                                        <option value="{{ $party->id }}">
                                                                            {{ $party->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('political_party_id')
                                                                <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card"
                                                    style="border: none; border-left: 1px solid #e3e7ea; border-radius: none; box-shadow: none;">
                                                    <div class="card-body">
                                                        <h3 class="card-title">Other Details</h3>
                                                        <div class="mb-3">
                                                            <label class="form-label">About Me (bio)</label>
                                                            <textarea class="form-control" placeholder="Here can be your description" name="about">{{ old('about') }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">City </label>
                                                            <input type="text"
                                                                class="form-control @error('city') is-invalid @enderror"
                                                                placeholder="City" name="city" id="input-city"
                                                                value="{{ old('city') }}" required>
                                                            @error('city')
                                                                <p class="invalid-feedback">{{ '*' . $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Postal Code </label>
                                                                    <input type="test" class="form-control"
                                                                        placeholder="ZIP Code" name="postal_code"
                                                                        value="{{ old('postal_code') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Phone</label>
                                                                    <input type="tel" name="phone"
                                                                        class="form-control" placeholder="000-000000-00"
                                                                        value="{{ old('phone') }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card-footer">
                                        <div class="btn-list" style="text-align: right;">
                                            <input class="btn" type="button" value="Cancel" />
                                            <button type="submit" class="btn btn-primary"
                                                id="addUser-form-submit">Submit</button>
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
        function preview() {
            const input = document.getElementById("formFile");
            const frame = document.getElementById("frame");

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    frame.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role-select');
            const partyWrapper = document.getElementById('party-select-wrapper');
            const partySelect = document.getElementById('party-select');
            roleSelect.addEventListener('change', function() {
                if (this.value === 'candidate') {
                    partyWrapper.style.display = 'block';
                    partyWrapper.style.maxHeight = partyWrapper.scrollHeight + 'px'; // Adjust as needed
                    partySelect.required = true;
                } else {
                    partyWrapper.style.display = 'none';
                    partyWrapper.style.maxHeight = '0';
                    partySelect.required = false;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#addUser-form").submit(function(e) {
                e.preventDefault();
                $(".invalid-feedback").remove();
                $("input").removeClass("is-invalid");

                var formData = new FormData(this);

                $('#addUser-form-btn').prop("disabled", true).html(
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

                            $("#addUser-form")[0].reset();
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
                                inputField.after('<p class="invalid-feedback">' + value[
                                    0] + '</p>');
                            });
                        } else {
                            toastr.error("Something went wrong!", "Error", {
                                positionClass: "toast-top-right"
                            });
                        }
                    },
                    complete: function() {
                        $('#addUser-form-btn').prop("disabled", false).html('Submit');
                    }
                });
            });
        });
    </script>

@stop
