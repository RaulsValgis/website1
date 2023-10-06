@extends('auth.layouts')

@section('content')

<style>
    .border-solid {
        border-style: solid;
        border-width: 1px;
    }

    .padding-5 {
        padding-top: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }


</style>

<div class="container">
    <a href="{{ route('cities.create') }}" class="btn btn-primary">Add</a>
</div>

@if(Session::has('sucess'))
    <div class="alert alert-sucess" role="alert">
        {{ Session::get('sucess') }}
    </div>
@endif

<div class="container">
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Country</th>
                <th>City</th>
                <th>Population</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($model->count() > 0)
                @foreach($model as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->country }}</td>
                        <td class="align-middle">{{ $rs->city }}</td>
                        <td class="align-middle">{{ $rs->population }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('cities.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{ route('cities.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('cities.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
</div>


@endsection

