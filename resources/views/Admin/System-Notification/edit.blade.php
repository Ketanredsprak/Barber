<div class="modal-dialog modal-lg" role="document">
    <?php
    $services = getServices();
    $locale = Illuminate\Support\Facades\App::getLocale();
    $name = "service_name_".$locale;
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Service') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('service.update', $data->id) }}" id="service-edit-form">
                @csrf
                <div class="row g-2">

                    <div class="col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.Main Service Name') }}</label>
                            <select class="form-select parent_id" name="parent_id" id="validationDefault04">
                            <option selected="" value="">{{ __('labels.Select Service') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @if($service->id == $data->parent_id) selected="selected" @endif>{{ $service->$name }}</option>
                                @endforeach
                            </select>
                            <div id="parent_id_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label" for="service_image">{{ __('labels.Service Image') }}  ({{ __('labels.Accept:png,jpg,jpeg') }})<span class="text-danger">*</span> </label>
                        <input class="form-control" id="service_image" name="service_image" type="file"
                            placeholder="{{ __('labels.Service Image') }}" aria-label="{{ __('labels.Service Image') }}" accept=".png, .jpg, .jpeg">
                        <div id="service_image_error" style="display: none;" class="text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label" for="service_image"></label><br>
                        <img src="@if(!empty($data->service_image)){{ static_asset('service_image/' . $data->service_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" class=""
                            style="height:30px">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="service_name_en">{{ __('labels.Service Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="service_name_en" name="service_name_en" type="text"
                            placeholder="{{ __('labels.Service Name English') }}" aria-label="{{ __('labels.Service Name English') }}" value="{{ $data->service_name_en}}">
                        <div id="service_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="service_name_ar">{{ __('labels.Service Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="service_name_ar" name="service_name_ar" type="text"
                            placeholder="{{ __('labels.Service Name Arabic') }}" aria-label="{{ __('labels.Service Name Arabic') }}" value="{{ $data->service_name_ar}}">
                        <div id="service_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="service_name_ur">{{ __('labels.Service Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="service_name_ur" name="service_name_ur" type="text"
                            placeholder="{{ __('labels.Service Name Urdu') }}" aria-label="{{ __('labels.Service Name Urdu') }}" value="{{ $data->service_name_ur}}">
                        <div id="service_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="service_name_tr">{{ __('labels.Service Name Turkish') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="service_name_tr" name="service_name_tr" type="text"
                            placeholder="{{ __('labels.Service Name Turkish') }}" aria-label="{{ __('labels.Service Name Turkish') }}" value="{{ $data->service_name_tr}}">
                        <div id="service_name_tr_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-check checkbox-checked">
                              <input class="form-check-input" id="gridCheck1" type="checkbox" name="is_special_service" value="1" @if($data->is_special_service == 1) checked="checked" @endif>
                              <label class="form-check-label" for="gridCheck1">{{ __('labels.Special Service') }}</label>
                        </div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="serviceSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>



