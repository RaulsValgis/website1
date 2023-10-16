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
@include('partials.add_modal')

<!-- Edit Modal -->
@include('partials.edit_modal')

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
    addData();
    }

    function addData() {
        $('#addForm').submit(function(e) {
            e.preventDefault();

            // Get the form data
            var formData = $(this).serialize();
            console.log('Form data:', formData);  // Log form data

            $.ajax({
                url: "{{ route('cities.store') }}",
                type: "POST",
                data: formData,  // Make sure "add_city" is included in the form data
                success: function(response) {
                    $('#addModal').modal('hide');
                    // Optionally, you can reload the page or update the table to reflect the new data
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error adding data:', error);
                    console.log('XHR status:', xhr.status);
                    console.log('Response text:', xhr.responseText);  // Log the response text

                    // Display a generic error message to the user
                    $('#addModal').find('.error-message').text('An error occurred while processing your request.');
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
                    $('#edit_city').val(response.edit_city);
                    $('#edit_population').val(response.edit_population);
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

            // Get the values of the input fields
            var countryName = $('#edit_country_name').val().trim();
            var city = $('#edit_city').val().trim();
            var population = $('#edit_population').val().trim();

            // Clear any previous error messages
            $('#editForm .error-message').text('');

            // Validate the input fields
            var hasErrors = false;
            if (countryName.length < 1 || countryName.length > 100) {
                $('#editForm .error-message.country-name').text('Country name must be between 1 and 100 characters.');
                hasErrors = true;
            }

            if (city.length < 1 || city.length > 100) {
                $('#editForm .error-message.city').text('City must be between 1 and 100 characters.');
                hasErrors = true;
            }

            // Check if population is a valid integer
            if (population !== '' && !Number.isInteger(parseInt(population))) {
                $('#editForm .error-message.population').text('Population must be a valid integer.');
                hasErrors = true;
            }

            if (hasErrors) {
                // There are validation errors, do not close the modal
                return;
            } else {
                // If no validation errors, proceed with the AJAX request
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
            }
        });

        // Show the edit modal
        $('#editModal').modal('show');
    }









    function closeAddModal() {
        $('#addModal').modal('hide');       
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