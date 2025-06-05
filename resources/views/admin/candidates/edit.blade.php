@extends('masterpage')
@section('title', 'Edit Candidate')
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
                    <h1>Edit Candidate</h1>
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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Edit Candidate</li>
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
        <div class="col-xl-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <div class="card-heading">
                        <h4 class="card-title">Candidate Information</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('candidates.update', $data->id)}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName4">Name*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName4" placeholder="Enter Name..." name="name" value="{{ old('name', $data->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCNIC4">CNIC No.*</label>
                                <input type="text" class="form-control @error('CNIC') is-invalid @enderror" id="inputCNIC4" name="CNIC" placeholder="xxxxx-xxxxxxx-x" value="{{ old('CNIC', $data->CNIC) }}" required>
                                @error('CNIC') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="selectAssembly">Select Assembly*</label>
                                <select id="selectAssembly" class="js-basic-single form-control @error('constituency_id') is-invalid @enderror" name="constituency_id" required>
                                    <option value="" disabled {{ old('constituency_id', $data->constituency_id) ? '' : 'selected' }}>--Select Assembly--</option>
                                    @if(isset($assemblies) && $assemblies->isNotEmpty())
                                        @foreach ($assemblies as $assembly)
                                            <option value="{{ $assembly->id }}" {{ old('constituency_id', $data->constituency_id) == $assembly->id ? 'selected' : '' }}>
                                                {{ $assembly->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Assemblies Found</option>
                                    @endif
                                </select>
                                @error('constituency_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="selectPoliticalParty">Select Political Party*</label>
                                <select id="selectPoliticalParty" class="js-basic-single form-control @error('political_party_id') is-invalid @enderror" name="political_party_id" required>
                                    <option value="" disabled {{ old('political_party_id', $data->political_party_id) ? '' : 'selected' }}>--Select Political Party--</option>
                                    @if(isset($parties) && $parties->isNotEmpty())
                                        @foreach ($parties as $party)
                                            <option value="{{ $party->id }}" {{ old('political_party_id', $data->political_party_id) == $party->id ? 'selected' : '' }}>
                                                {{ $party->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Parties Found</option>
                                    @endif
                                </select>
                                @error('political_party_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="inputAddress" placeholder="1234 Main St" name="address" rows="3">{{ old('address', $data->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail4" placeholder="Email" name="email" value="{{ old('email', $data->email) }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPhone4">Phone</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="inputPhone4" placeholder="03xxxxxxxxx" name="phone" value="{{ old('phone', $data->phone) }}" pattern="03[0-9]{9}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="inputCity" name="city" placeholder="Enter City..." value="{{ old('city', $data->city) }}">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>


@endsection

@section('js')



@stop