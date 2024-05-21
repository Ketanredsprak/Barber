<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Country') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('country.update', $data->id) }}" id="country-edit-form">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_short_name">{{ __('labels.Country Short Name') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_short_name" name="country_short_name" type="text"
                            placeholder="{{ __('labels.Country Short Name') }}" aria-label="{{ __('labels.Country Short Name') }}" value="{{ $data->shortname }}">
                        {{-- <div id="country_short_name_error" style="display: none;" class="text-danger"></div> --}}
                    </div>


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_en">{{ __('labels.Country Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_en" name="country_name_en" type="text"
                            placeholder="{{ __('labels.Country Name English') }}" aria-label="{{ __('labels.Country Name English') }}" value="{{ $data->name_en }}">
                        {{-- <div id="country_name_en_error" style="display: none;" class="text-danger"></div> --}}
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_ar">{{ __('labels.Country Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_ar" name="country_name_ar" type="text"
                            placeholder="{{ __('labels.Country Name Arabic') }}" aria-label="{{ __('labels.Country Name Arabic') }}" value="{{ $data->name_ar }}">
                        {{-- <div id="country_name_ar_error" style="display: none;" class="text-danger"></div> --}}
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_ur">{{ __('labels.Country Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_ur" name="country_name_ur" type="text"
                            placeholder="{{ __('labels.Country Name Urdu') }}" aria-label="{{ __('labels.Country Name Urdu') }}" value="{{ $data->name_ur }}">
                        {{-- <div id="country_name_ur_error" style="display: none;" class="text-danger"></div> --}}
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_phone_code">{{ __('labels.Country Phone Code') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_phone_code" name="country_phone_code" type="text"
                            placeholder="{{ __('labels.Country Phone Code') }}" aria-label="{{ __('labels.Country Phone Code') }}" value="{{ $data->phonecode }}">
                        {{-- <div id="country_phone_code_error" style="display: none;" class="text-danger"></div> --}}
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="countrySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
