@extends('auth.layouts')

@section('content')

<h1 class="mb-0">Edit Product</h1>
    <hr />
    <form action="{{ route('cities.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Country" value="{{ $model->country }}" >
            </div>
            <div class="col mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" placeholder="City" value="{{ $model->city }}" >
            </div>
            <div class="col mb-3">
                <label class="form-label">Population</label>
                <input type="text" name="population" class="form-control" placeholder="Population" value="{{ $model->population }}" >
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>

@endsection