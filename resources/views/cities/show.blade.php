@extends('auth.layouts')

@section('content')

<h1 class="mb-0">Detail</h1>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Country</label>
            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $model->country }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">City</label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $model->city }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Population</label>
            <input type="text" name="product_code" class="form-control" placeholder="Product Code" value="{{ $model->copulation }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $model->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $model->updated_at }}" readonly>
        </div>
    </div>


@endsection