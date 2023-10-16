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
                    <label for="add_city">{{ __('City') }}</label>
                    <input type="text" name="add_city" id="add_city" class="form-control" placeholder="{{ __('City') }}" autocomplete="address-level2">
                </div>

                <div class="form-group">
                    <label for="add_population">{{ __('Population') }}</label>
                    <input type="text" name="add_population" id="add_population" class="form-control" placeholder="{{ __('Population') }}" autocomplete="off">
                </div>
                <div class="error-message text-danger"></div>
                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
            </form>
        </div>
    </div>
</div>
</div>