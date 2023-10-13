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