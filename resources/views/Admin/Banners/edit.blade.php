<div class="modal-dialog modal-lg" role="document">
    <?php
        $barbers = getbarbers();
     ?>
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Banner') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('banner.update', $data->id) }}" id="banner-edit-form">
                @csrf
                <div class="row g-2">

                        <div class="col-md-6">
                            <label class="form-label" for="validationServer01">{{ __('labels.Barber') }}</label>
                                <select class="form-select barber_id" name="barber_id" id="validationDefault04">
                                <option selected="" value="">{{ __('labels.Select Barber') }}</option>
                                    @foreach ($barbers as $barber)
                                        <option value="{{ $barber->id }}" @if($barber->id  == $data->barber_id) selected="selected" @endif>{{ $barber->first_name }} {{ $barber->last_name }}</option>
                                    @endforeach
                                </select>
                                <div id="barber_id_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="col-md-5">
                            <label class="form-label" for="banner_image">{{ __('labels.Banner Image') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" id="banner_image" name="banner_image" type="file" accept=""
                                placeholder="{{ __('labels.Banner Image') }}" aria-label="{{ __('labels.Banner Image') }}" accept=".png, .jpg, .jpeg">
                            <div id="banner_image_error" style="display: none;" class="text-danger"></div>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label" for="banner_image"></label><br>
                            <img src="@if(!empty($data->banner_image)){{ static_asset('banner_image/' . $data->banner_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" class=""
                                style="height:28px">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title_en">{{ __('labels.Title English') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" id="title_en" name="title_en" type="text"
                                placeholder="{{ __('labels.Title English') }}" aria-label="{{ __('labels.Title English') }}" value="{{ $data->title_en}}">
                            <div id="title_en_error" style="display: none;" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title_ar">{{ __('labels.Title Arabic') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" id="title_ar" name="title_ar" type="text"
                                placeholder="{{ __('labels.Title Arabic') }}" aria-label="{{ __('labels.Title Arabic') }}" value="{{ $data->title_ar}}">
                            <div id="title_ar_error" style="display: none;" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Content English') }}<span class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" id="content_en" name="content_en" rows="5" placeholder="{{ __('labels.Content English') }}">{{ $data->content_en}}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Content Arabic') }}<span class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" id="content_ar" name="content_ar" rows="5" placeholder="{{ __('labels.Content Arabic') }}">{{ $data->content_ar }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title_ur">{{ __('labels.Title Urdu') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" id="title_ur" name="title_ur" type="text"
                                placeholder="{{ __('labels.Title Urdu') }}" aria-label="{{ __('labels.Title Urdu') }}"  value="{{ $data->title_ur}}">
                            <div id="title_ur_error" style="display: none;" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title_tr">{{ __('labels.Title Turkish') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" id="title_tr" name="title_tr" type="text"
                                placeholder="{{ __('labels.Title Turkish') }}" aria-label="{{ __('labels.Title Turkish') }}" value="{{ $data->title_tr}}">
                            <div id="title_tr_error" style="display: none;" class="text-danger"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Content Urdu') }}<span class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" id="content_ur" name="content_ur" rows="5" placeholder="{{ __('labels.Content Urdu') }}">{{ $data->content_ur}}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Content Turkish') }}<span class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" id="content_tr" name="content_tr" rows="5" placeholder="{{ __('labels.Content Turkish') }}">{{ $data->content_tr}}</textarea>
                        </div>


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="bannerSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
