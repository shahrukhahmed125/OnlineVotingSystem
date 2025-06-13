@extends('masterpage')
@section('title', 'Add New Election')
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
                    <h1>Add Election</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Add Election</li>
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
                <form action="{{route('admin.elections.store')}}" method="POST" id="election-form">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Details</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputTitle">Election Title*</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" placeholder="Enter Title..." name="title" value="{{ old('title') }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="selectAssembly">Select Type*</label>
                                <select id="selectAssembly" class="js-basic-single form-control @error('type') is-invalid @enderror" name="type" required>
                                    <option value="" selected disabled>--Select</option>
                                    <option value="general assembly">General Assembly</option>
                                    <option value="national assembly">National Assembly</option>
                                    <option value="provincial assembly">Provincial Assembly</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputStartTime">Start Time*</label>
                                <input type="text" name="start_time" class="form-control date-picker-default @error('start_time') is-invalid @enderror" id="inputStartTime" placeholder="Select Date..." value="{{ old('start_time') }}" required>
                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEndTime">End Time*</label>
                                <input type="text" name="end_time" class="form-control date-picker-default @error('end_time') is-invalid @enderror" id="inputEndTime" placeholder="Select Date..." value="{{ old('end_time') }}" required>
                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-4 align-self-center">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" name="is_active" id="inputIsActive" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inputIsActive">
                                        Is Active?
                                    </label>
                                    @error('is_active') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>    
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" placeholder="Add more details..." name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <input class="btn" type="button" value="Cancel"/>
                            <button type="submit" class="btn btn-primary" id="election-form-btn">Submit</button>
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
        $("#election-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("input").removeClass("is-invalid");

            var formData = $(this).serialize();

            $('#election-form-btn').prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm"></span> Processing...'
            );

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message, "Success", {
                            positionClass: "toast-top-right"
                        });

                        $("#election-form")[0].reset();
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
                            var inputField = $("input[name='" + key + "']");
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
                    $('#election-form-btn').prop("disabled", false).html('Submit');
                }
            });
        });
    });

</script>  

@stop