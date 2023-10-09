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
    <a href="{{ route('cities.create') }}" class="btn btn-primary">{{ __('Add') }}</a>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<!-- fix this ^ -->

<div class="container">
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>{{ __('Country') }}</th>
                <th>{{ __('City') }}</th>
                <th>{{ __('Population') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($model->count() > 0)
                @foreach($model as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->countries ? $rs->countries->name : 'N/A' }}</td>
                        <td class="align-middle">{{ $rs->city }}</td>
                        <td class="align-middle">{{ $rs->population }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('cities.show', $rs->id) }}" type="button" class="btn btn-secondary">{{ __('Detail') }}</a>
                                <a href="{{ route('cities.edit', $rs->id) }}" type="button" class="btn btn-warning">{{ __('Edit') }}</a>
                                <form action="{{ route('cities.destroy', $rs->id) }}" method="POST" class="btn btn-danger p-0" onsubmit="return confirm('{{ __('Delete') }}')">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-danger m-0">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">{{ __('No Data Found') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection