@extends('auth.layouts')

@section('content')

<div class="container">
    <div class="row">
        <strong><h1>Add</h1></strong>
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf

        <div class="row mb-3">
            <div class="row mb-3">
                <div class="col">
                    Country Dropdown
                    <select name="country_dropdown" id="country_dropdown" class="form-control" autocomplete="country">
                        <option value="">Select a country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    Country
                    <input type="text" name="country_name" id="country_name" class="form-control" placeholder="Country" autocomplete="country">
                    @error('country_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    City
                    <input type="text" name="city" class="form-control" placeholder="City" autocomplete="address-level2">
                    @error('city')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    Population
                    <input type="text" name="population" class="form-control" placeholder="Population" autocomplete="off">
                    @error('population')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="d-grid">
                    <button class="btn btn-primary">ADD</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif


<script>
    document.getElementById('country_dropdown').addEventListener('change', function() {
        document.getElementById('country_name').value = this.value;
        document.getElementById('country_name').readOnly = false;  
    });
</script>

@endsection