<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">{{ __('Edit Data') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeEditModal()">
                    <span aria-hidden="true">X</span>
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
                    <label for="edit_city">{{ __('City') }}</label>
                    <input type="text" name="edit_city" id="edit_city" class="form-control" placeholder="{{ __('City') }}" autocomplete="address-level2">
                </div>

                <div class="form-group">
                    <label for="edit_population">{{ __('Population') }}</label>
                    <input type="text" name="edit_population" id="edit_population" class="form-control" placeholder="{{ __('Population') }}" autocomplete="address-level2">
                </div>
                <div class="error-message text-danger"></div>
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </form>
        </div>
    </div>
</div>
</div>