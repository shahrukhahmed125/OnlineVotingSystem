@extends('masterpage')
@section('title', 'Top Political Parties')
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
                <div class="col-xl-4 col-sm-6">
                    <div class="card card-statistics employees-contant px-2">
                        <div class="card-body pb-5 pt-4">
                            <div class="text-center">
                                <div class="text-right">
                                    <h4><span class="badge badge-primary badge-pill px-3 py-2">$50/hr</span></h4>
                                </div>
                                <div class="pt-1 bg-img m-auto"><img src="{{ asset('assets/img/avtar/01.jpg') }}" class="img-fluid"
                                        alt="employees-img"></div>
                                <div class="mt-3 employees-contant-inner">
                                    <h4 class="mb-1">{{ ucwords($vote->name) }}</h4>
                                    <h5 class="mb-0 text-muted">{{ ucwords($vote->abbreviation) }}</h5>
                                    <div class="mt-3 ">
                                        <span class="badge badge-pill badge-success-inverse px-3 py-2">UI</span>
                                        <span class="badge badge-pill badge-primary-inverse px-3 py-2">UX</span>
                                        <span class="badge badge-pill badge-info-inverse px-3 py-2">Photoshop</span>
                                        <span class="badge badge-pill badge-warning-inverse px-3 py-2">+7</span>
                                    </div>
                                </div>
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
