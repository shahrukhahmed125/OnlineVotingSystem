@extends('masterpage')
@section('title', 'Political Parties List')

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
                        <h1>Political Parties List</h1>
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
                                <li class="breadcrumb-item active text-primary" aria-current="page">Political Parties List
                                </li>
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
                                        <th scope="col">Symbol</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Leader</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($politicalParties as $item)
                                        <tr id="party-row-{{ $item->id }}">
                                            <td>
                                                @if ($item->images)
                                                    <img src="{{ $item->images->isNotEmpty() ? asset('storage/' . $item->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}"
                                                        alt="Party Symbol"
                                                        style="width:40px; height:40px; object-fit:cover;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ ucwords($item->name) . ' (' . ucwords($item->abbreviation) . ')' }}</td>
                                            <td>{{ $item->leader_name ? ucwords($item->leader_name) : 'null' }}</td>
                                            <td class="text-wrap">{{ $item->details ? ucwords($item->details) : 'null' }}
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
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.political_parties.edit', $item->id) }}">Edit</a>
                                                        <a class="dropdown-item" href="#">Details</a>
                                                        <a class="dropdown-item" href="#">Candidates</a>
                                                        <a class="dropdown-item text-danger" type="button"
                                                            data-toggle="modal"
                                                            data-target="#deletePartyModal{{ $item->id }}">Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Delete party Modal -->
                                        <div class="modal fade" id="deletePartyModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deletePartyModalLabel{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-danger">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title text-white"
                                                            id="deletePartyModalLabel{{ $item->id }}">
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
                                                        Are you sure you want to delete this party?
                                                        <br>
                                                        <strong>This action cannot be undone.</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>

                                                        <button type="button" class="btn btn-danger delete-party-btn"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.political_parties.destroy', $item->id) }}">
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
        $(document).on('click', '.delete-party-btn', function() {
            let button = $(this);
            let url = button.data('url');
            let id = button.data('id'); // get the party ID
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

                        // Remove deleted party row/card from DOM
                        $('#party-row-' + id).remove(); // or $('#party-card-' + id).remove();

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
