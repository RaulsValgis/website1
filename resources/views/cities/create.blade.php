@extends('auth.layouts')

@section('content')

<div class="container">
    <div class="row">
        <strong><h1>Add</h1></strong>
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    Country
                    <input type="text" name="country" class="form-control" placeholder="Country" autocomplete="country">
                </div>
                <div class="col">
                    City
                    <input type="text" name="city" class="form-control" placeholder="City" autocomplete="address-level2">
                </div>
                <div class="col">
                    Population
                    <input type="text" name="population" class="form-control" placeholder="Population" autocomplete="off">
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


@endsection