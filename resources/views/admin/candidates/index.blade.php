@extends('masterpage')
@section('title', 'Candidates List')

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
                        <h1>Candidates List</h1>
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
                                <li class="breadcrumb-item active text-primary" aria-current="page">Candidates List</li>
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
            <div class="col-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="export-table-wrapper datatable-wrapper table-responsive">
                            <table id="export-table" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">CNIC</th>
                                        <th scope="col">Nomination</th>
                                        <th scope="col">Political Party</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->user->user_id }}</td>
                                            <td>{{ ucwords($item->user->name) }}<br>
                                                <small class="text-muted"><a
                                                        href="mailto:{{ $item->user->email }}">{{ $item->user->email }}</a></small>
                                            </td>
                                            <td>{{ ucwords($item->user->cnic) }}</td>
                                            @php
                                                // Track if candidate has any assigned assembly
                                                $hasAssembly = false;
                                            @endphp

                                            @if($item->elections->isNotEmpty())
                                                @foreach($item->elections as $election)
                                                    @php
                                                        $assemblyId = $election->pivot->assembly_id;
                                                        $assembly = $assemblyId ? $assemblies->firstWhere('id', $assemblyId) : null;
                                                    @endphp

                                                    @if ($assemblyId && $assembly)
                                                        @php $hasAssembly = true; @endphp
                                                        <td>
                                                            {{ '(' . $election->election_id . ') ' . ($election->title ?? 'N/A') }}<br>
                                                            <small class="text-muted">(Assembly: {{ $assembly->name }})</small>
                                                        </td>
                                                    @else
                                                        <td>Not Assign</td>
                                                    @endif
                                                @endforeach
                                            @else
                                                <td>Not Assign</td>
                                            @endif
                                            <td>
                                                @if ($item->politicalParty && $item->politicalParty->name)
                                                    {{ ucwords($item->politicalParty->name) }}
                                                    @if ($item->politicalParty->abbreviation)
                                                        ({{ strtoupper($item->politicalParty->abbreviation) }})
                                                    @endif
                                                @else
                                                    null
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton{{ $item->id }}" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        @if($item->elections->isEmpty())
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#assignModal{{ $item->id }}">Assign</a>
                                                        @endif
                                                        <form action="{{ route('admin.candidates.destroy', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Are you sure you want to delete this election?')">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Assign Modal -->
                                        <div class="modal fade" id="assignModal{{ $item->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="assignModal{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Assign Election to Candidate</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="assign-form-{{ $item->id }}" method="POST"
                                                        action="{{ route('admin.candidates.assign', $item->id) }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="assembly_id">Select Assembly*</label>
                                                                <select id="assembly_id"
                                                                    class="js-basic-single form-control"
                                                                    name="assembly_id" required>
                                                                    <option selected disabled>--Select</option>
                                                                    @if ($assemblies->isNotEmpty())
                                                                        @foreach ($assemblies as $assembly)
                                                                            <option value="{{ $assembly->id }}">
                                                                                {{ $assembly->name }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Assemblies Found</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="election_id">Select Election*</label>
                                                                <select id="election_id"
                                                                    class="js-basic-single form-control" name="election_id"
                                                                    required>
                                                                    <option selected disabled>--Select</option>
                                                                    @if ($elections->isNotEmpty())
                                                                        @foreach ($elections as $election)
                                                                            <option value="{{ $election->id }}">
                                                                                {{ ('('.$election->election_id . ') ' . ucwords($election->title)) }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Elections Found</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" id="assign-form-submit-{{ $item->id }}"
                                                                class="btn btn-success">Assign</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $(document).on("submit", "form[id^='assign-form-']", function(e) {
                e.preventDefault();
                var $form = $(this);
                var submitBtn = $form.find("button[type='submit']");

                $form.find(".invalid-feedback").remove();
                $form.find("input, select").removeClass("is-invalid");

                var formData = $form.serialize();

                submitBtn.prop("disabled", true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Processing...'
                );

                $.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right"
                            });
                            $form[0].reset();
                            $form.closest(".modal").modal("hide");
                            location.reload();
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
                                var field = $form.find("[name='" + key + "']");
                                field.addClass("is-invalid");
                                field.after('<p class="invalid-feedback">' + value[0] + '</p>');
                            });
                        } else {
                            toastr.error("Something went wrong!", "Error", {
                                positionClass: "toast-top-right"
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop("disabled", false).html("Assign");
                    }
                });
            });
        });
    </script>


@stop
