<div class="modal-dialog" role="document">
    <?php $countrys = getcountries();
     $locale = Illuminate\Support\Facades\App::getLocale();
    $name = "name_".$locale;
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1"> {{ __('labels.Add City') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('city.store') }}" id="city-frm">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.Country Name') }}</label>
                            <select class="form-select country_id" name="country_id" id="validationDefault04">
                            <option selected="" value="">{{ __('labels.Select Country') }}</option>
                                @foreach ($countrys as $country)
                                    <option value="{{ $country->id }}">{{ $country->$name }}</option>
                                @endforeach
                            </select>
                            <div id="country_id_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6 d-none" id="states">
                            <div class="form-group" >
                                <label class="form-label" for="validationServer01">{{ __('labels.State Name') }}</label>
                                <select class="form-control stateData" name="state_id" id="stateData" id="validationDefault04">
                                    <option value="">{{ __('labels.Select State') }}</option>
                                </select>
                                <div id="state_id_error" style="display: none;" class="text-danger"></div>
                            </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_en">{{ __('labels.City Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_en" name="city_name_en" type="text"
                            placeholder="{{ __('labels.City Name English') }}" aria-label="{{ __('labels.City Name English') }}">
                        <div id="city_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ar">{{ __('labels.City Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ar" name="city_name_ar" type="text"
                            placeholder="{{ __('labels.City Name Arabic') }}" aria-label="{{ __('labels.City Name Arabic') }}">
                        <div id="city_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ur">{{ __('labels.City Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ur" name="city_name_ur" type="text"
                            placeholder="{{ __('labels.City Name Urdu') }}" aria-label="{{ __('labels.City Name Urdu') }}">
                        <div id="city_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>


