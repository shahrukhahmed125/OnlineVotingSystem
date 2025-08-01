@extends('masterpage')
@section('title', 'Cast Vote')
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
                    <h1>Cast Vote</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Cast Vote</li>
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
                <form action="#" method="POST" id="vote-form">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Details</h4>
                    </div>
                </div>
                <div class="card-body">
                        <input type="hidden" name="election_id" value="{{ $election->id }}">
                        <input type="hidden" name="assembly_id" value="{{ $assembly->id }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Select Candidate*</label>
                                    <select id="inputState" class="js-basic-single form-control" name="constituency_id" required>
                                        <option selected disabled>--Select</option>
                                        @if ($candidates->isNotEmpty())
                                            @foreach ($candidates as $candidate)
                                                <option value="{{$candidate->id}}">{{$candidate->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Candidates Found</option>
                                        @endif
                                    </select>
                            </div>
                        </div>    
                        <div class="form-group">
                            <label for="inputAddress">Description</label>
                            <textarea type="text" class="form-control" id="inputAddress" placeholder="Add more details..." name="description" row="3"></textarea>
                        </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <input class="btn" type="button" value="Cancel"/>
                            <button type="submit" class="btn btn-primary" id="vote-form-btn">Submit</button>
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
        $("#vote-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("input").removeClass("is-invalid");

            var formData = $(this).serialize();

            $('#vote-form-btn').prop("disabled", true).html(
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

                        $("#vote-form")[0].reset();
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
                    $('#vote-form-btn').prop("disabled", false).html('Submit');
                }
            });
        });
    });

</script>  

@stop