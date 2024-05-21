<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Customer') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('customer.update',$data->id) }}" id="customer-edit-form" enctype="multipart/form-data">
                @csrf
                @method('put')
                  <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="name">{{ __('labels.Name') }}<span class="text-danger">*</span> </label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="{{ __('labels.Name') }}" aria-label="{{ __('labels.Name') }}" value="{{ $data->name }}">
                        <div id="name_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="phone">{{ __('labels.Phone') }}<span class="text-danger">*</span> </label>
                        <input class="form-control" id="phone" name="phone" type="number"
                            placeholder="{{ __('labels.Phone') }}" aria-label="{{ __('labels.Phone') }}" value="{{ $data->phone }}">
                        <div id="phone_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-sm-10">
                        <label class="form-label" for="profile_image">{{ __('labels.Profile Image') }}</label>
                        <input class="form-control" id="profile_image" type="file" name="profile_image"
                            accept=".png, .jpg, .jpeg">
                        <div id="profile_image_error" style="display: none;" class="text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label" for="profile_image"></label><br>
                        <img src="@if(!empty($data->profile_image)){{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" class=""
                            style="height:28px">
                    </div>


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i>{{ __('labels.Submit') }} </button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>


