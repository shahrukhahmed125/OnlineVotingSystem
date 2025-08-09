@extends('masterpage')
@section('title', 'Votes')
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
                                    <a href="{{ route('admin.home') }}"><i class="ti ti-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    Dashboard
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">Votes</li>
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
                            <table id="export-table" class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Voter</th>
                                        <th scope="col">Candidate Voted</th>
                                        <th scope="col">Assembly NA/PA</th>
                                        <th scope="col">Election</th>
                                        <th scope="col">Time of Vote</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($votes as $item)
                                        <tr id="vote-row-{{ $item->id }}">
                                            <td>{{ ucwords($item->voter->name ?? '') }}<br>
                                                <span class="text-muted"><small>{{ $item->voter->cnic ?? '' }}</small></span>
                                            </td>
                                            <td>{{ ucwords($item->candidate->user->name ?? '') }}<br>
                                                <span class="text-muted"><small>{{ $item->candidate->politicalParty->abbreviation ?? '' }}</small></span>
                                            </td>
                                            <td>{{ ucwords($item->assembly->name ?? '') }}</td>
                                            <td>{{'('.$item->election->election_id .') '.$item->election->title ?? 'N/A'  }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-inverse-danger delete-vote-btn" type="button"
                                                    data-id="{{ $item->id }}"
                                                    data-url="{{ route('admin.votes.destroy', $item->id) }}"
                                                    data-toggle="modal"
                                                    data-target="#deleteVoteModal{{ $item->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Delete Election Modal -->
                                        <div class="modal fade" id="deleteVoteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteVoteModalLabel{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-danger">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title text-white"
                                                            id="deleteVoteModalLabel{{ $item->id }}">
                                                            Confirm Deletion
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <i class="ti ti-alert text-danger" style="font-size: 3rem;"></i>
                                                        <br><br>
                                                        Are you sure you want to delete this vote?
                                                        <br>
                                                        <strong>This action cannot be undone.</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>

                                                        <button type="button" class="btn btn-danger confirm-delete-vote"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.votes.destroy', $item->id) }}">
                                                            Yes, Delete
                                                        </button>
                                                    </div>
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
        $(document).on('click', '.confirm-delete-vote', function() {
            let button = $(this);
            let url = button.data('url');
            let id = button.data('id'); // get the vote ID
            let modal = button.closest('.modal');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message, "Success", {
                            positionClass: "toast-top-right"
                        });

                        // Close modal
                        modal.modal('hide');

                        // Remove deleted vote row/card from DOM
                        $('#vote-row-' + id).remove(); // or $('#vote-card-' + id).remove();

                    } else {
                        toastr.error(response.message, "Error", {
                            positionClass: "toast-top-right"
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error("Something went wrong.", "Error", {
                        positionClass: "toast-top-right"
                    });
                }
            });
        });
    </script>

@stop
