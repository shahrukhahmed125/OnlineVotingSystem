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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            padding: 4px;
        }

        .card-statistics {
            border-radius: 10px;
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
            <div class="col-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="container">
                                <form onsubmit="submitElectionReport(event,this)" id="electionreportformsubmit" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="form-label">Select Elections</label>
                                                <select required name="election" class="form-control select2">
                                                    <option value="">--Select</option>
                                                    @foreach ($elections as $election)
                                                        <option value="{{ $election->id }}">
                                                            {{ ucwords($election->title) }}<br>
                                                            <small>{{ $election->election_id }}</small>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
            
                                        <div class="col-sm-2 ">
                                            <button class="w-100 btn btn-primary mt-4" type="submit"
                                                id="electionreportformsubmit-btn">Submit</button>
                                        </div>
                                    </div>
                                </form>        
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-10" id="election_report">
                     {{-- Cards will load here after AJAX call --}}
                </div>
            </div>
        </div>

        <!--end employees contant-->
    </div>

@endsection

@section('js')

{{-- JS for AJAX Submission --}}
<script>
function submitElectionReport(e, form) {
    e.preventDefault();
    const btn = document.getElementById('electionreportformsubmit-btn');
    btn.disabled = true;
    btn.innerText = 'Loading...';

    fetch("{{ route('admin.votes.by_party') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            election_id: form.election.value
        })
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('election_report');
        container.innerHTML = '';

        if (data.length > 0) {
            const electionStatus = data[0]?.election_status || null;

            if (electionStatus === 'completed') {
                // Find the party with the highest votes
                const winner = data.reduce((prev, current) => 
                    Number(current.total_votes) > Number(prev.total_votes) ? current : prev
                );

                container.innerHTML += `
                    <div class="col-xl-6 col-sm-6 mb-4">
                        <div class="card card-statistics h-100 shadow-sm border-0 hover-shadow">
                            <div class="card-body p-4 text-center">
                                <div class="vote-count mb-3">
                                    <h2>${Number(winner.total_votes).toLocaleString()}</h2>
                                    <small>Total Votes</small>
                                </div>
                                <div class="m-auto mb-3">
                                    <img src="${winner.image_url}" class="party-logo border border-light" alt="party-img">
                                </div>
                                <h4 class="mt-3 mb-1 text-dark font-weight-bold">${winner.name}</h4>
                                <h5 class="mb-0 text-muted">(${winner.abbreviation.toUpperCase()})</h5>
                                <div class="mt-2 text-success fw-bold">Winner</div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Render all parties
            data.forEach(vote => {
                container.innerHTML += `
                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card card-statistics h-100 shadow-sm border-0 hover-shadow">
                            <div class="card-body p-4 text-center">
                                <div class="vote-count mb-3">
                                    <h2>${Number(vote.total_votes).toLocaleString()}</h2>
                                    <small>Total Votes</small>
                                </div>
                                <div class="m-auto mb-3">
                                    <img src="${vote.image_url}" class="party-logo border border-light" alt="party-img">
                                </div>
                                <h4 class="mt-3 mb-1 text-dark font-weight-bold">${vote.name}</h4>
                                <h5 class="mb-0 text-muted">(${vote.abbreviation.toUpperCase()})</h5>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            container.innerHTML = `<div class="col-12 text-center text-muted">No data found for this election.</div>`;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Something went wrong.');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerText = 'Submit';
    });
}
</script>

@stop
