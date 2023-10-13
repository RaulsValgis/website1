@extends('auth.layouts')

@section('content')
<style> .border-solid { border-style: solid; border-width: 1px; } .padding-5 { padding-top: 5px; padding-bottom: 5px;
    margin-bottom: 5px; } </style>

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