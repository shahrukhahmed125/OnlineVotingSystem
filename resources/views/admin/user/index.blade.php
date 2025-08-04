@extends('masterpage')
@section('title', 'Users List')

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
                        <h1>Users List</h1>
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
                                <li class="breadcrumb-item active text-primary" aria-current="page">Users List</li>
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
                                        <th scope="col">ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">CNIC</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">City</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr id="user-row-{{ $item->id }}">
                                            <td><span class="text-nowrap">{{ ucwords($item->user_id) }}</span></td>
                                            <td>
                                                {{ ucwords($item->name) }}<br>
                                                <small class="text-muted">
                                                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                                </small>
                                            </td>
                                            <td>{{ ucwords($item->cnic) }}</td>
                                            <td>{{ ucwords($item->gender) }}</td>
                                            <td>{{ ucwords($item->city) }}</td>
                                            <td>{{ ucwords($item->getRoleNames()->first()) }}</td>
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
                                                        
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.users.edit', $item->id) }}" style="{{ $item->hasRole('admin') ? 'display:none;' : '' }}">Edit
                                                        </a>
                                                        <a class="dropdown-item text-danger" type="button"
                                                            data-toggle="modal" style="{{ $item->hasRole('admin') ? 'display:none;' : '' }}"
                                                            data-target="#deleteUserModal{{ $item->id }}">Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete User Modal -->
                                        <div class="modal fade" id="deleteUserModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteUserModalLabel{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-danger">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title text-white"
                                                            id="deleteUserModalLabel{{ $item->id }}">
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
                                                        Are you sure you want to delete this user?
                                                        <br>
                                                        <strong>This action cannot be undone.</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>

                                                    <button type="button" class="btn btn-danger delete-user-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-url="{{ route('admin.users.destroy', $item->id) }}">
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
    $(document).on('click', '.delete-user-btn', function () {
        let button = $(this);
        let url = button.data('url');
        let id = button.data('id'); // get the user ID
        let modal = button.closest('.modal');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message, "Success", {
                        positionClass: "toast-top-right"
                    });

                    // Close modal
                    modal.modal('hide');

                    // Remove deleted user row/card from DOM
                    $('#user-row-' + id).remove(); // or $('#user-card-' + id).remove();

                } else {
                    toastr.error(response.message, "Error", {
                        positionClass: "toast-top-right"
                    });
                }
            },
            error: function (xhr) {
                toastr.error("Something went wrong.", "Error", {
                    positionClass: "toast-top-right"
                });
            }
        });
    });
</script>

@stop
