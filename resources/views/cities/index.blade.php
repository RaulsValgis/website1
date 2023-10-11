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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" id="addModal" onclick="closeAddModal()">X</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addForm" action="{{ route('cities.store') }}" method="POST">
                @csrf

                <!-- Form fields for adding data -->
                <div class="form-group">
                    <label for="add_country_dropdown">{{ __('Country Dropdown') }}</label>
                    <select name="add_country_dropdown" id="add_country_dropdown" class="form-control" autocomplete="country">
                        <!-- Populate options dynamically based on your data -->
                        <option value="">{{ __('Select a Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">    
                    <label for="add_country_name">{{ __('Country') }}</label>
                    <input type="text" name="add_country_name" id="add_country_name" class="form-control" placeholder="{{ __('Country') }}" autocomplete="address-level2">
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
            <form id="editForm" action="{{ isset($model) && $model->isNotEmpty() ? route('cities.update', $model->first()->id) : '#' }}" method="POST">
                @csrf


                    <div class="form-group">
                    <label for="edit_country_dropdown">{{ __('Country Dropdown') }}</label>
                    <select name="edit_country_dropdown" id="edit_country_dropdown" class="form-control" autocomplete="country">
                            <!-- Populate options dynamically based on your data -->
                            <option value="">{{ __('Select a Country') }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">    
                        <label for="edit_country_name">{{ __('Country') }}</label>
                        <input type="text" name="edit_country_name" id="edit_country_name" class="form-control" placeholder="{{ __('Country') }}" autocomplete="address-level2">
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
                                <button type="button" class="btn btn-warning" onclick="openEditModal({{ $rs->id }}, {{ json_encode($model) }})">{{ __('Edit') }}</button>
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
 
    function openEditModal(id, model) {
    if (Array.isArray(model) && model.length > 0) {
        const selectedModel = model.find(item => item.id === id);

        if (selectedModel) {
            // Make an AJAX request to fetch the data for the specified ID
            $.ajax({
                url: `{{ url('cities') }}/${id}/edit`,
                type: "GET",
                success: function (response) {
                    // Populate the form fields with the retrieved data
                    $('#edit_country_name').val(response.edit_country_name);
                    $('#city').val(response.city);
                    $('#population').val(response.population);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });

            const actionUrl = `{{ url('cities') }}/${id}/update`;
            $('#editForm').attr('action', actionUrl);
            $('#editModal').modal('show');
        } else {
            console.error('Model not found for ID: ', id);
        }
    } else {
        console.error('Model is empty or null.');
    }
}


    function submitEditForm(model) {
    var $actionUrl = model.length > 0 ? "{{ route('cities.update', '') }}/" + model[0].id : '';

    $('#editForm').attr('action', $actionUrl);

    $('#editForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $actionUrl,
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                $('#editModal').modal('hide');
            },
            error: function (error) {
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
        const addCountryDropdown = document.getElementById('add_country_dropdown');
        const addCountryNameInput = document.getElementById('add_country_name');

        const editCountryDropdown = document.getElementById('edit_country_dropdown');
        const editCountryNameInput = document.getElementById('edit_country_name');

        if (addCountryDropdown && addCountryNameInput) {
            addCountryDropdown.addEventListener('change', function() {
                addCountryNameInput.value = this.value;
                addCountryNameInput.readOnly = false;
            });
        } else {
            console.error('Add Country dropdown or country name input not found.');
        }

        if (editCountryDropdown && editCountryNameInput) {
            editCountryDropdown.addEventListener('change', function() {
                editCountryNameInput.value = this.value;
                editCountryNameInput.readOnly = false;
            });
        } else {
            console.error('Edit Country dropdown or country name input not found.');
        }
    });


</script>
@endsection



