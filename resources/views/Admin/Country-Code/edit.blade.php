<div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Country') }}</h5>

            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>

        </div>

        <div class="modal-body" id="myModal">

            <form class="form-bookmark" method="post" action="{{ route('country-code.update', $data->id) }}" id="country-edit-form">

                @csrf

                <div class="row g-2">



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="name">{{ __('labels.Country Name') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="name" name="name" type="text"

                            placeholder="{{ __('labels.Country Name') }}" aria-label="{{ __('labels.Country Name') }}" value="{{ $data->name }}">

                        <div id="name_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="short_name">{{ __('labels.Country Short Name') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="short_name" name="short_name" type="text"

                            placeholder="{{ __('labels.Country Short Name') }} " aria-label="{{ __('labels.Country Short Name') }}" value="{{ $data->short_name }}">

                        <div id="short_name_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="phonecode">{{ __('labels.Country Phone Code') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="phonecode" name="phonecode" type="text"

                            placeholder="{{ __('labels.Country Phone Code') }}" aria-label="{{ __('labels.Country Phone Code') }}" value="{{ $data->phonecode }}">

                        <div id="phonecode_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>





                    <div class="col-md-6">

                        <label class="form-label" for="image">{{ __('labels.Image') }}  ({{ __('labels.Accept:png,jpg,jpeg') }}) (300px * 200px) <span class="text-danger">*</span> </label>

                        <input class="form-control" id="image" name="image" type="file" accept=""

                            placeholder="{{ __('labels.Image') }}" aria-label="{{ __('labels.Image') }}" accept=".png, .jpg, .jpeg">

                        <div id="image_error" style="display: none;" class="text-danger"></div>

                    </div>

                    {{-- <div class="col-md-1">

                        <label class="form-label" for="image"></label><br>

                        <img src="@if(!empty($data->image)){{ static_asset('image/' . $data->image) }}@else{{ static_asset('/admin/assets/images/no-image.png') }}@endif" class=""

                            style="height:28px">

                    </div> --}}



                </div>

                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="countrySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"

                    id="is_close">{{ __('labels.Close') }}</button>

            </form>

        </div>

    </div>

</div>

