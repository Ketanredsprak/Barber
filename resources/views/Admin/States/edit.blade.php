<div class="modal-dialog" role="document">
    <?php $countrys = getcountries();
    $locale = Illuminate\Support\Facades\App::getLocale();
    $name = "name_".$locale;
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit State') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('state.update', $data->id) }}" id="state-edit-form">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.Country Name') }}</label>
                            <select class="form-select" name="country_id" id="validationDefault04">
                            <option selected="" value="">{{ __('labels.Select Country') }}</option>
                                @foreach ($countrys as $country)
                                    <option value="{{ $country->id }}" @if($data->country_id == $country->id) selected @endif>{{ $country->$name }}</option>
                                @endforeach
                            </select>
                            <div id="country_id_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_en">{{ __('labels.State Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_en" name="state_name_en" type="text"
                            placeholder="{{ __('labels.State Name English') }}" aria-label="{{ __('labels.State Name English') }}" value="{{ $data->name_en }}">
                        <div id="state_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_ar">{{ __('labels.State Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_ar" name="state_name_ar" type="text"
                            placeholder="{{ __('labels.State Name Arabic') }}" aria-label="{{ __('labels.State Name Arabic') }}"  value="{{ $data->name_ar }}">
                        <div id="state_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_ur">{{ __('labels.State Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_ur" name="state_name_ur" type="text"
                            placeholder="{{ __('labels.State Name Urdu') }}" aria-label="{{ __('labels.State Name Urdu') }}" value="{{ $data->name_ur }}">
                        <div id="state_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="stateSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
