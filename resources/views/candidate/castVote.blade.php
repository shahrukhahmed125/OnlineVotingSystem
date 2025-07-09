@extends('dashboard')
@section('title', 'Cast Vote')
@section('css')


@stop

@section('content')

    <div class="container">
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
                                    <a href="{{ route('candidate.dashboard') }}"><i class="ti ti-home"></i></a>
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
                        <div class="card card-statistics  px-2" style="box-shadow: none; border: 1px solid #e0e0e0;">
                            <div class="card-body">

                                @if (empty($election))
                                    <div class="alert alert-warning">
                                        No elections are currently available for voting.
                                    </div>
                                @elseif ($election->type === 'general assembly')
                                    <h5 class="mb-4">Provincial Assembly (PA)</h5>
                                    @php $paCandidates = $candidates->filter(fn($c) => $c->assembly->type === 'PA'); @endphp
                                    @if ($paCandidates->isNotEmpty())
                                        <div class="row mb-5">
                                            @foreach ($paCandidates as $candidate)
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card card-statistics  px-2">
                                                        <div class="card-body pb-5 pt-4">
                                                            <div class="text-center">
                                                                <div class="text-right">
                                                                    <h4><span class="badge badge-info badge-pill px-3 py-2">{{$candidate->politicalParty->abbreviation}}</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="pt-1 bg-img m-auto">
                                                                    <img src="{{ $candidate->photo_url ?? asset('assets/img/avtar/01.jpg') }}"
                                                                        class="img-fluid" alt="candidate-img">
                                                                </div>
                                                                <div class="mt-3 -inner">
                                                                    <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                                    <h5 class="mb-0 text-muted">
                                                                        {{ $candidate->designation ?? 'Candidate' }}</h5>
                                                                    <div class="mt-3">
                                                                        <span
                                                                            class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                            {{ $candidate->politicalParty->name ?? 'Independent' }}
                                                                        </span>
                                                                    </div>
                                                                    <form action="#" method="POST" class="mt-3">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-block">Vote</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No Candidates Found for Provincial Assembly
                                        </div>
                                    @endif

                                    <h5 class="mb-4">National Assembly (NA)</h5>
                                    @php $naCandidates = $candidates->filter(fn($c) => $c->assembly->type === 'NA'); @endphp
                                    @if ($naCandidates->isNotEmpty())
                                        <div class="row">
                                            @foreach ($naCandidates as $candidate)
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card card-statistics  px-2">
                                                        <div class="card-body pb-5 pt-4">
                                                            <div class="text-center">
                                                                <div class="text-right">
                                                                    <h4><span class="badge badge-info badge-pill px-3 py-2">{{$candidate->politicalParty->abbreviation}}</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="pt-1 bg-img m-auto">
                                                                    <img src="{{ $candidate->image ?? asset('assets/img/avtar/01.jpg') }}"
                                                                        class="img-fluid" alt="candidate-img">
                                                                </div>
                                                                <div class="mt-3 -inner">
                                                                    <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                                    <h5 class="mb-0 text-muted">
                                                                        {{ $candidate->designation ?? 'Candidate' }}</h5>
                                                                    <div class="mt-3">
                                                                        <span
                                                                            class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                            {{ $candidate->politicalParty->name ?? 'Independent' }}
                                                                        </span>
                                                                    </div>
                                                                    <form action="#" method="POST" class="mt-3">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-block">Vote</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No Candidates Found for National Assembly
                                        </div>
                                    @endif
                                @else
                                    <h5 class="mb-4">{{ strtoupper($election->type) }}</h5>
                                    @if ($candidates->isNotEmpty())
                                        <div class="row">
                                            @foreach ($candidates as $candidate)
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card card-statistics  px-2">
                                                        <div class="card-body pb-5 pt-4">
                                                            <div class="text-center">
                                                                <div class="pt-1 bg-img m-auto">
                                                                    <img src="{{ $candidate->photo_url ?? asset('assets/img/avtar/01.jpg') }}"
                                                                        class="img-fluid" alt="candidate-img">
                                                                </div>
                                                                <div class="mt-3 -inner">
                                                                    <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                                    <h5 class="mb-0 text-muted">
                                                                        {{ $candidate->designation ?? 'Candidate' }}</h5>
                                                                    <div class="mt-3">
                                                                        <span
                                                                            class="badge badge-pill badge-success-inverse px-3 py-2">
                                                                            {{ $candidate->politicalParty->name ?? 'Independent' }}
                                                                        </span>
                                                                    </div>
                                                                    <form action="#" method="POST" class="mt-3">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-block">Vote</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No Candidates Found for this Election
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')

@stop
