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
                                <a href="{{route('admin.home')}}"><i class="ti ti-home"></i></a>
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
                                    <th scope="col">Constituency</th>
                                    <th scope="col">Political Party</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->user->user_id }}</td>
                                    <td>{{ucwords($item->user->name)}}<br>
                                        <small class="text-muted"><a href="mailto:{{$item->user->email}}">{{$item->user->email}}</a></small>
                                    </td>
                                    <td>{{ucwords($item->user->cnic)}}</td>
                                    <td>{{ $item->assembly->name ? ucwords($item->assembly->name) : 'null' }}</td>
                                    <td>
                                        @if($item->politicalParty && $item->politicalParty->name)
                                            {{ ucwords($item->politicalParty->name) }}
                                            @if($item->politicalParty->abbreviation)
                                                ({{ strtoupper($item->politicalParty->abbreviation) }})
                                            @endif
                                        @else
                                            null
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                <a class="dropdown-item" href="#">View</a>
                                                <a class="dropdown-item" href="{{route('admin.candidates.edit', $item->id)}}">Edit</a>
                                                <form action="{{route('admin.candidates.destroy', $item->id)}}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this election?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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


@stop