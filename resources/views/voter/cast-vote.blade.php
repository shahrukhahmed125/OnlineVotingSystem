@extends('masterpage')
@section('title', 'Cast Your Vote')
@section('css')
{{-- Add any specific CSS if needed --}}
@stop

@section('content')

<div class="container-fluid">
    <!-- begin row -->
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Cast Your Vote</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('voter.dashboard') }}"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Voter Dashboard
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
                <form action="{{ route('voter.vote.store') }}" method="POST" id="vote-form">
                @csrf
                <div class="card-header">
                    <div class="card-heading">
                        {{-- <h4 class="card-title">Election: {{ $election->title }} ({{ $assembly->name }})</h4> --}}
                    </div>
                </div>
                <div class="card-body">
                        {{-- <input type="hidden" name="election_id" value="{{ $election->id }}">
                        <input type="hidden" name="assembly_id" value="{{ $assembly->id }}"> --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="candidate_id">Select Candidate*</label>
                                    <select id="candidate_id" class="js-basic-single form-control" name="candidate_id" required>
                                        <option value="" selected disabled>--Select Your Candidate--</option>
                                        {{-- @if ($candidates->isNotEmpty())
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }} ({{ $candidate->politicalParty->name ?? 'Independent' }})</option>
                                            @endforeach
                                        @else
                                            <option value="">No Candidates Found for this Election</option>
                                        @endif --}}
                                    </select>
                            </div>
                        </div>    
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <div class="btn-list" style="text-align: right;">
                            <a href="{{ route('voter.dashboard') }}" class="btn">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="vote-form-btn">Submit Vote</button>
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
        // Initialize select2 if you are using it for js-basic-single
        if ($.fn.select2) {
            $('.js-basic-single').select2();
        }

        $("#vote-form").submit(function(e) {
            e.preventDefault();
            $(".invalid-feedback").remove();
            $("select, input").removeClass("is-invalid");

            var formData = $(this).serialize();

            $('#vote-form-btn').prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm"></span> Processing...'
            );

            $.ajax({
                url: $(this).attr("action"), // Uses the form's action attribute
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message, "Success", {
                            positionClass: "toast-top-right",
                            onHidden: function () {
                                // Optional: Redirect after toast disappears
                                // window.location.href = "{{ route('voter.dashboard') }}";
                            }
                        });
                        // $("#vote-form")[0].reset(); // Reset form
                        // Disable form elements after successful vote to prevent re-submission
                        $('#vote-form-btn').prop("disabled", true).text('Vote Cast Successfully');
                        $('#candidate_id').prop("disabled", true);

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
                            var inputField = $("select[name='" + key + "'], input[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.closest('.form-group').append('<p class="invalid-feedback d-block">' + value[0] + '</p>');
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message || "Something went wrong!", "Error", {
                            positionClass: "toast-top-right"
                        });
                    }
                },
                complete: function(xhr) {
                    // Only re-enable button if not successful vote
                     if (xhr.responseJSON && xhr.responseJSON.status !== 'success') {
                        $('#vote-form-btn').prop("disabled", false).html('Submit Vote');
                    }
                }
            });
        });
    });

</script>  

@stop
