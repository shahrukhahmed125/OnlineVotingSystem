@extends('dashboard')
@section('title', 'Cast Vote')
@section('css')

    <style>
        .selectable-card.selected-card {
            border: 2px solid #007bff !important;
            box-shadow: 0 0 10px #007bff33;
            background: #eaf4ff;
        }
    </style>

@stop

@section('content')

    <div class="container">
        @if ($user->votes->isNotEmpty())
        <div class="row m-t-100 justify-content-center align-items-center" style="height: 700px;">
            <div class="col-md-12">
            <div class="card text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 400px;">
                <h4 class="card-title">Vote Status</h4>
                <p class="card-text">You have already cast your vote in this election.</p>
                <a href="javascript:back()" class="btn btn-primary mt-2">Go Back</a>
                </div>
            </div>
            </div>
        </div>
        @else
            <!-- begin row -->
            <div class="row m-t-100">
                <div class="col-md-12 m-b-30">
                    <!-- begin page title -->
                    <div class="d-block d-lg-flex flex-nowrap align-items-center">
                        <div class="page-title mr-4 pr-4 border-right">
                            <h1>Cast Vote</h1>
                        </div>
                        <div class="breadcrumb-bar align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('voter.dashboard') }}"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item text-primary active">
                                        Cast Vote
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end page title -->
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <div class="card-heading">
                                <h4 class="card-title">Please Select a Candidate to Cast Your Vote</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card card-statistics px-2" style="box-shadow: none;">
                                <div class="card-body">
                                    @if (empty($election))
                                        <div class="alert alert-warning">
                                            No elections are currently available for voting.
                                        </div>
                                    @elseif ($election->type === 'general assembly')
                                        <form action="{{ route('voter.storeVote') }}" method="POST" id="voteForm">
                                            @csrf
                                            <div class="card-heading">
                                                <h4 class="card-title mb-4">Provincial Assembly (PA)</h4>
                                            </div>
                                            @php $paCandidates = $candidates->filter(fn($c) => $c->assembly->type === 'PA'); @endphp
                                            @if ($paCandidates->isNotEmpty())
                                                <div class="row mb-5">
                                                    @foreach ($paCandidates as $candidate)
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="selectable-card card card-statistics px-2"
                                                                data-group="pa" data-id="{{ $candidate->id }}"
                                                                style="cursor:pointer;">
                                                                <div class="card-body pb-5 pt-4">
                                                                    <input type="hidden" name="pa_candidate_id"
                                                                        id="pa_candidate_id" value="{{ $candidate->id }}"
                                                                        required>
                                                                    <input type="hidden" name="pa_assembly_id"
                                                                        value="{{ $candidate->constituency_id }}">
                                                                    <div class="text-center">
                                                                        <div class="text-right">
                                                                            <h4>
                                                                                <span
                                                                                    class="badge badge-pill badge-info-inverse px-3 py-2">{{ ucwords($candidate->politicalParty->symbol) }}</span>
                                                                            </h4>
                                                                        </div>
                                                                        <div class="pt-1 bg-img m-auto">
                                                                            <img src="{{ $candidate->politicalParty->images->isNotEmpty() ? asset('storage/' . $candidate->politicalParty->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}"
                                                                                class="img-fluid" alt="candidate-img">
                                                                        </div>
                                                                        <div class="mt-3 -inner">
                                                                            <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                                            <h5 class="mb-0 text-muted">
                                                                                {{ ucwords($candidate->politicalParty->name) ?? 'Candidate' }}
                                                                            </h5>
                                                                            <div class="mt-3">
                                                                                <span
                                                                                    class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                                    {{ ucwords($candidate->politicalParty->abbreviation) ?? 'IND' }}
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="election_id" value="{{ $election->id }}">
                                            @else
                                                <div class="alert alert-warning">
                                                    No Candidates Found for Provincial Assembly
                                                </div>
                                            @endif
                                            <div class="card-heading">
                                                <h4 class="card-title mb-4">National Assembly (NA)</h4>
                                            </div>
                                            @php $naCandidates = $candidates->filter(fn($c) => $c->assembly->type === 'NA'); @endphp
                                            @if ($naCandidates->isNotEmpty())
                                                <div class="row">
                                                    @foreach ($naCandidates as $candidate)
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="selectable-card card card-statistics px-2"
                                                                data-group="na" data-id="{{ $candidate->id }}"
                                                                style="cursor:pointer;">
                                                                <div class="card-body pb-5 pt-4">
                                                                    <input type="hidden" name="na_candidate_id"
                                                                        id="na_candidate_id" value="{{ $candidate->id }}"
                                                                        required>
                                                                    <input type="hidden" name="na_assembly_id"
                                                                        value="{{ $candidate->constituency_id }}">
                                                                    <div class="text-center">
                                                                        <div class="text-right">
                                                                            <h4>
                                                                                <span
                                                                                    class="badge badge-pill badge-info-inverse px-3 py-2">{{ ucwords($candidate->politicalParty->symbol) }}
                                                                                </span>
                                                                            </h4>
                                                                        </div>
                                                                        <div class="pt-1 bg-img m-auto">
                                                                            <img src="{{ $candidate->politicalParty->images->isNotEmpty() ? asset('storage/' . $candidate->politicalParty->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}"
                                                                                class="img-fluid" alt="candidate-img">
                                                                        </div>
                                                                        <div class="mt-3 -inner">
                                                                            <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                                            <h5 class="mb-0 text-muted">
                                                                                {{ ucwords($candidate->politicalParty->name) ?? 'Candidate' }}
                                                                            </h5>
                                                                            <div class="mt-3">
                                                                                <span
                                                                                    class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                                    {{ $candidate->politicalParty->abbreviation ?? 'IND' }}
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="election_id" value="{{ $election->id }}">
                                            @else
                                                <div class="alert alert-warning">
                                                    No Candidates Found for National Assembly
                                                </div>
                                            @endif
                                            <div class="col-12">
                                                <div class="card-footer">
                                                    <div class="btn-list" style="text-align: right;">
                                                        <input class="btn" type="button" value="Cancel"
                                                            onclick="window.history.back();" />
                                                        <button type="submit" class="btn btn-primary"
                                                            id="party-form-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('candidate.storeVote') }}" method="POST" id="voteForm">
                                            @csrf
                                            <h5 class="mb-4">{{ strtoupper($election->type) }}</h5>
                                            @if ($candidates->isNotEmpty())
                                                <div class="row">
                                                    @foreach ($candidates as $candidate)
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="selectable-card card card-statistics px-2"
                                                                data-group="single" data-id="{{ $candidate->id }}"
                                                                style="cursor:pointer;">
                                                                <div class="card-body pb-5 pt-4">
                                                                    <input type="hidden" name="candidate_id"
                                                                        id="candidate_id" value="{{ $candidate->id }}"
                                                                        required>
                                                                    <input type="hidden" name="assembly_id"
                                                                        value="{{ $candidate->constituency_id }}">
                                                                    <div class="text-center">
                                                                        <div class="pt-1 bg-img m-auto">
                                                                            <img src="{{ $candidate->politicalParty->images->isNotEmpty() ? asset('storage/' . $candidate->politicalParty->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}"
                                                                                class="img-fluid" alt="candidate-img">
                                                                        </div>
                                                                        <div class="mt-3 -inner">
                                                                            <h4>
                                                                                <span
                                                                                    class="badge badge-pill badge-info-inverse px-3 py-2">{{ ucwords($candidate->politicalParty->symbol) }}</span>
                                                                            </h4>
                                                                            <h5 class="mb-0 text-muted">
                                                                                {{ ucwords($candidate->politicalParty->name) ?? 'Candidate' }}
                                                                            </h5>
                                                                            <div class="mt-3">
                                                                                <span
                                                                                    class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                                    {{ $candidate->politicalParty->abbreviation ?? 'IND' }}
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="election_id" value="{{ $election->id }}">
                                                <div class="col-12">
                                                    <div class="card-footer">
                                                        <div class="btn-list" style="text-align: right;">
                                                            <input class="btn" type="button" value="Cancel"
                                                                onclick="window.history.back();" />
                                                            <button type="submit" class="btn btn-primary"
                                                                id="party-form-btn">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    No Candidates Found for this Election
                                                </div>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop
@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // For general assembly
            document.querySelectorAll('.selectable-card[data-group="pa"]').forEach(function(card) {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.selectable-card[data-group="pa"]').forEach(function(
                        c) {
                        c.classList.remove('selected-card');
                    });
                    card.classList.add('selected-card');
                    document.getElementById('pa_candidate_id').value = card.getAttribute('data-id');
                });
            });
            document.querySelectorAll('.selectable-card[data-group="na"]').forEach(function(card) {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.selectable-card[data-group="na"]').forEach(function(
                        c) {
                        c.classList.remove('selected-card');
                    });
                    card.classList.add('selected-card');
                    document.getElementById('na_candidate_id').value = card.getAttribute('data-id');
                });
            });
            // For other elections
            document.querySelectorAll('.selectable-card[data-group="single"]').forEach(function(card) {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.selectable-card[data-group="single"]').forEach(
                        function(c) {
                            c.classList.remove('selected-card');
                        });
                    card.classList.add('selected-card');
                    document.getElementById('candidate_id').value = card.getAttribute('data-id');
                });
            });
        });
    </script>
@stop
