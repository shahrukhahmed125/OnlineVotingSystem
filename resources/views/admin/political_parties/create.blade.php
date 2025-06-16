@extends('masterpage')
@section('title', 'Add Political Party')

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
                    <h1>Add Political Party</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Add Political Party</li>
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
                <form action="{{ route('admin.political_parties.store') }}" method="POST" id="party-form" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Details</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Party Name*</label>
                                <input type="text" class="form-control" id="inputName" placeholder="Enter Name..." name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAbbreviation">Abbreviation*</label>
                                <input type="text" class="form-control" id="inputAbbreviation" name="abbreviation" placeholder="Enter Abbreviation..." value="{{ old('abbreviation') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputLeader_name">Leader Name*</label>
                                <input type="text" class="form-control" id="inputLeader_name" placeholder="Enter Name..." name="leader_name" value="{{ old('leader_name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputFounded_year">Founded At*</label>
                                <input type="text" name="founded_at" class="form-control date-picker-default" id="inputFounded_year" placeholder="Select Date..." value="{{ old('founded_at') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputLeader_name">Symbol / Image*</label>
                                <input class="form-control @error('img') is-invalid @enderror" 
                                    name="img" placeholder="Upload Image Here..." value="{{ old('img') }}" 
                                    type="file" accept="image/*"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputHead_office">Head Office</label>
                            <textarea class="form-control" id="inputHead_office" rows="3" placeholder="Head office street address..." name="head_office"></textarea>
                        </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <input class="btn" type="button" value="Cancel"/>
                            <button type="submit" class="btn btn-primary" id="party-form-btn">Submit</button>
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