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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">{{ __('Add Data') }}</h5>
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true" id="addModal" onclick="closeAddModal()">X</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addForm" action="{{ route('cities.store') }}" method="POST">
                @csrf

                <!-- Form fields for adding data -->
                <div class="form-group">
                    <label for="country_dropdown">{{ __('Country Dropdown') }}</label>
                    <select name="country_dropdown" id="country_dropdown" class="form-control" autocomplete="country">
                        <!-- Populate options dynamically based on your data -->
                        <option value="">{{ __('Select a Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">    
                    <label for="country_name">{{ __('Country') }}</label>
                    <input type="text" name="country_name" id="country_name" class="form-control" placeholder="{{ __('Country') }}" autocomplete="address-level2">
                </div>
                <div class="form-group">
                    <label for="city">{{ __('City') }}</label>
                    <input type="text" name="city" class="form-control" placeholder="{{ __('City') }}" autocomplete="address-level2">
                </div>

                <div class="form-group">
                    <label for="population">{{ __('Population') }}</label>
                    <input type="text" name="population" class="form-control" placeholder="{{ __('Population') }}" autocomplete="off">
                </div>
                <div class="error-message text-danger"></div>
                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">{{ __('Edit Data') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="editmodal" onclick="closeEditModal()">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('cities.update', $model->first()->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                    <label for="country_dropdown">{{ __('Country Dropdown') }}</label>
                    <select name="country_dropdown" id="country_dropdown" class="form-control" autocomplete="country">
                            <!-- Populate options dynamically based on your data -->
                            <option value="">{{ __('Select a Country') }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">    
                        <label for="country_name">{{ __('Country') }}</label>
                        <input type="text" name="country_name" id="country_name" class="form-control" placeholder="{{ __('Country') }}" autocomplete="address-level2">
                    </div>

                <div class="form-group">
                    <label for="city">{{ __('city') }}</label>
                    <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('city') }}" autocomplete="address-level2">
                </div>

                <div class="form-group">
                    <label for="population">{{ __('population') }}</label>
                    <input type="text" name="population" id="population" class="form-control" placeholder="{{ __('population') }}" autocomplete="address-level2">
                </div>
                <div class="error-message text-danger"></div>
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </form>
        </div>
    </div>
</div>
</div>

<div class="container">
    <button type="button" class="btn btn-primary" onclick="openAddModal()">{{ __('Add') }}</button>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

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
                                <button type="button" class="btn btn-warning" onclick="openEditModal({{ $rs->id }})">{{ __('Edit') }}</button>
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

<script>
    function openAddModal() {
    $('#addModal').modal('show');
}

    function addData() {
        $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('cities.store') }}",
            type: "POST",
            data: $('#addForm').serialize(),
            success: function(response) {
                $('#addModal').modal('hide');
            },
            error: function(error) {
                console.error('Error adding data:', error);
                $('#addModal').find('.error-message').text(error.responseJSON.message);
            }
        });
    });
    }
 
    function openEditModal(id) {
    $.ajax({
        url: `/cities/${id}/edit`, 
        type: "GET",
        success: function(response) {
            $('#country_dropdown').val(response.country);
            $('#edit_city').val(response.city);
            $('#edit_population').val(response.population);

            $('#editModal').modal('show');
        },
        error: function(error) {
            console.error('Error fetching data for edit:', error);
        }
    });
    }


    function submitEditForm() {
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('cities.update', $model->first()->id) }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#editModal').modal('hide');
            },
            error: function(error) {
                console.error('Error updating data:', error);
            }
        });
    });
    }


    function closeAddModal() {
        $('#addModal').modal('hide');
        // const addModal = document.getElementById('addModal');
        // addModal.remove();
        
    }

    function closeEditModal() {
        $('#editModal').modal('hide');
    }



    

    document.addEventListener('DOMContentLoaded', (event) => {
    const countryDropdown = document.getElementById('country_dropdown');
    const countryNameInput = document.getElementById('country_name');


    if (countryDropdown && countryNameInput) {
        countryDropdown.addEventListener('change', function() {
            countryNameInput.value = this.value;
            countryNameInput.readOnly = false;  
        });
    } else {
        console.error('Country dropdown or country name input not found.');
    }
    });


</script>
@endsection



