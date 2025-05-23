@extends('masterpage')
@section('title', 'Add Assembly')

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
                    <h1>Add Assembly</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Add Assembly</li>
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
                <form action="{{ route('admin.assembly.store') }}" method="POST" id="assembly-form">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Details</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Name*</label>
                                <input type="text" class="form-control" id="inputName" placeholder="Enter Name..." name="name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputType">Type*</label>
                                <select id="inputType" class="form-control" name="type">
                                    <option selected disabled>--Select</option>
                                    <option value="NA">National Assembly (NA)</option>
                                    <option value="PA">Provincial Assembly (PA)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputProvince">Province</label>
                                <input type="text" class="form-control" id="inputProvince" name="province" placeholder="Enter Province...">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputDistrict">District</label>
                                <input type="text" class="form-control" id="inputDistrict" placeholder="Enter District..." name="district">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea class="form-control" id="inputDescription" rows="3" placeholder="Description..." name="description"></textarea>
                        </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <input class="btn" type="button" value="Cancel"/>
                            <button type="submit" class="btn btn-primary" id="assembly-form-btn">Submit</button>
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
        $("#assembly-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("input").removeClass("is-invalid");

            var formData = $(this).serialize();

            $('#assembly-btn').prop("disabled", true).html(
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

                        $("#assembly-form")[0].reset();
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
                    $('#assembly-btn').prop("disabled", false).html('Submit');
                }
            });
        });
    });

</script>    

@stop