@extends('masterpage')
@section('title', 'Top Political Parties')
@section('css')

<style>
    .hover-shadow {
        transition: all 0.3s ease-in-out;
    }

    .hover-shadow:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2) !important;
        transform: translateY(-5px) scale(1.02);
    }

    .vote-count {
        display: inline-block;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(6px);
        border-radius: 12px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .vote-count h2 {
        font-size: 2.4rem;
        line-height: 1.2;
        background: linear-gradient(45deg, #4e73df, #1cc88a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        margin-bottom: 0;
    }

    .vote-count small {
        letter-spacing: 0.5px;
        font-weight: 500;
        color: #6c757d;
    }

    .party-logo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 4px solid #fff;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        padding: 4px;
    }

    .card-statistics {
        border-radius: 15px;
        background: linear-gradient(180deg, #ffffff, #f9f9f9);
    }
</style>

@stop

@section('content')

    <div class="container-fluid">
        <!-- begin row -->
        <div class="row">
            <div class="col-md-12 m-b-30">
                <!-- begin page title -->
                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                    <div class="page-title mb-2 mb-sm-0">
                        <h1>Top Parties</h1>
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
                                <li class="breadcrumb-item active text-primary" aria-current="page">Top Parties</li>
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
        @foreach ($votesByParty as $vote)
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card card-statistics h-100 shadow-sm border-0 hover-shadow">
                    <div class="card-body p-4 text-center">
                        <!-- Vote count -->
                        <div class="vote-count mb-3">
                            <h2>{{ number_format($vote->total_votes) }}</h2>
                            <small>Total Votes</small>
                        </div>

                        <!-- Party logo -->
                        <div class="m-auto mb-3">
                            <img src="{{ $vote->images->isNotEmpty() ? asset('storage/' . $vote->images->first()->image_path) : asset('static/avatars/male-avatar-defualt.png') }}"
                                class="party-logo border border-light"
                                alt="party-img">
                        </div>

                        <!-- Party details -->
                        <div>
                            <h4 class="mt-3 mb-1 text-dark font-weight-bold">{{ ucwords($vote->name) }}</h4>
                            <h5 class="mb-0 text-muted">{{ '('.strtoupper($vote->abbreviation).')' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <!--end employees contant-->
    </div>

@endsection

@section('js')


@stop
