@extends('auth.layouts')

@section('content')

<h1 class="mb-0">{{ __('Detail') }}</h1>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">{{ __('Country') }}</label>
            <input type="text" name="title" class="form-control" placeholder="{{ __('Country') }}" value="{{ $model->countries->name }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">{{ __('City') }}</label>
            <input type="text" name="price" class="form-control" placeholder="{{ __('City') }}" value="{{ $model->city }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">{{ __('Population') }}</label>
            <input type="text" name="product_code" class="form-control" placeholder="{{ __('Population') }}" value="{{ $model->population }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">{{ __('Created at') }}</label>
            <input type="text" name="created_at" class="form-control" placeholder="{{ __('Created at') }}" value="{{ $model->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">{{ __('Updated at') }}</label>
            <input type="text" name="updated_at" class="form-control" placeholder="{{ __('Updated at') }}" value="{{ $model->updated_at }}" readonly>
        </div>
    </div>


@endsection