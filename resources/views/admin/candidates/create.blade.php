@extends('masterpage')
@section('title', 'Add Candidate')
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
                    <h1>Add Candidate</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Add Candidate</li>
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
                <form action="{{route('admin.candidates.store')}}" method="POST" id="candidate-form">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Details</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName4">Name*</label>
                                <input type="text" class="form-control" id="inputName4" placeholder="Enter Name..." name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCINC4">CNIC No.*</label>
                                <input type="text" class="form-control" id="inputCNIC4" name="CNIC" placeholder="xxxxx-xxxxxxx-x" required >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Select Assembly*</label>
                                    <select id="inputState" class="js-basic-single form-control" name="constituency_id" required>
                                        <option selected disabled>--Select</option>
                                        @if ($assemblies->isNotEmpty())
                                            @foreach ($assemblies as $assembly)
                                                <option value="{{$assembly->id}}">{{$assembly->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Assemblies Found</option>
                                        @endif
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Select Political Party*</label>
                                    <select id="inputState" class="js-basic-single form-control" name="political_party_id" required>
                                        <option selected disabled>--Select</option>
                                        @if ($party->isNotEmpty())
                                            @foreach ($party as $party)
                                                <option value="{{$party->id}}">{{$party->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Parties Found</option>
                                        @endif
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPhone4">Phone</label>
                                <input type="tel" class="form-control" id="inputPhone4" placeholder="03xxxxxxxxx" name="phone" pattern="03\d{9}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity" name="city" placeholder="Enter City...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <textarea type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" row="3"></textarea>
                        </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <input class="btn" type="button" value="Cancel"/>
                            <button type="submit" class="btn btn-primary" id="candidate-form-btn">Submit</button>
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
        $("#candidate-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("input").removeClass("is-invalid");

            var formData = $(this).serialize();

            $('#candidate-form-btn').prop("disabled", true).html(
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

                        $("#candidate-form")[0].reset();
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
                    $('#candidate-form-btn').prop("disabled", false).html('Submit');
                }
            });
        });
    });

</script>  

@stop