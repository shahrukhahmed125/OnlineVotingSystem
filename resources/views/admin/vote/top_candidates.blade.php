@extends('masterpage')
@section('title', 'Live Top Candidates')
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
                        <h1>Live Top Candidates</h1>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <nav>
                            <ol class="breadcrumb p-0 m-b-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html"><i class="ti ti-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    Pages
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">Live Top Candidates</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- end page title -->
            </div>
        </div>
        <!-- end row -->

        <!--start contact contant-->

        <div class="row">
            @if ($TopCandidates->isNotEmpty())
                @foreach ($TopCandidates as $candidate)
                    <div class="col-xxl-3 col-xl-4 col-sm-6">
                        <div class="card card-statistics contact-contant">
                            <div class="card-body py-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-img">
                                        <img src="{{ $candidate->politicalParty->images->isNotEmpty() ? asset('storage/' . $candidate->politicalParty->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}" alt="" class="img-fluid">
                                    </div>
                                    <div class="ml-3">
                                        @foreach ($candidate->assemblies as $assembly)
                                            <small class="d-block mb-1"><strong>{{ ucwords($assembly->name) }}</strong></small>
                                        @endforeach
                                        <h4 class="mb-0">{{ ucwords($candidate->user->name) }}</h4>
                                        @foreach ($TotalVotersPerAssembly as $data)
                                            @php
                                                $totalUsers = $data['total_users'];
                                                $votePercentage = $totalUsers > 0 
                                                    ? round(($candidate->votes_count / $totalUsers) * 100, 1)
                                                    : 0;

                                                // Determine progress bar color class
                                                $progressClass = 'bg-danger';
                                                if ($votePercentage >= 70) {
                                                    $progressClass = 'bg-success';
                                                } elseif ($votePercentage >= 40) {
                                                    $progressClass = 'bg-warning';
                                                }
                                            @endphp
                                        @endforeach

                                        <ul class="list-inline mb-1 mt-1">
                                            <li class="list-inline-item"><small><strong>Total Voters: {{ number_format($totalUsers) }}</strong></small></li>
                                            <li class="list-inline-item">|</li>
                                            <li class="list-inline-item"><small><strong>Total Votes: {{ number_format($candidate->votes_count) }}</strong></small></li>
                                            <li class="list-inline-item">|</li>
                                            <li class="list-inline-item"><small><strong>{{ $votePercentage . '%' }}</strong></small></li>
                                        </ul>

                                        <div class="progress my-2" style="height: 5px;">
                                            <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                                style="width: {{ $votePercentage }}%;" 
                                                aria-valuenow="{{ $votePercentage }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <div class="img-icon"><i class="ti ti-agenda"></i></div>
                                        </li>
                                        <li class="nav-item">
                                            <p><small>{{ ucwords($candidate->politicalParty->name). ' ('.$candidate->politicalParty->abbreviation.')' }}</small></p>
                                        </li>
                                    </ul>
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <div class="img-icon"><i class="fa fa-address-card-o"></i></div>
                                        </li>
                                        <li class="nav-item">
                                            <p><small>{{ $candidate->user->cnic }}</small></p>
                                        </li>
                                    </ul>
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <div class="img-icon"><i class="fa fa-envelope-o"></i></div>
                                        </li>
                                        <li class="nav-item">
                                            <p><small>{{ $candidate->user->email }}</small></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <strong>No candidates found.</strong>
                    </div>
                </div>    
            @endif
        </div>

        <!--end contact contant-->
    </div>

@endsection

@section('js')


@stop
