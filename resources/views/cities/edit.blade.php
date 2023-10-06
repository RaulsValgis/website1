@extends('auth.layouts')

@section('content')

<h1 class="mb-0">Edit Product</h1>
    <hr />
    <form action="{{ route('cities.update', $model->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="row">
        <div class="col mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="{{ $model->countries->name }}" autocomplete="off">
        </div>
            <div class="col mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ $model->city }}" autocomplete="off">
            </div>
            <div class="col mb-3">
                <label for="population" class="form-label">Population</label>
                <input type="text" name="population" id="population" class="form-control" placeholder="Population" value="{{ $model->population }}" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>

@endsection