<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Customer') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('customer.store') }}" id="customer-frm" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="name">{{ __('labels.Name') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="{{ __('labels.Name') }}" aria-label="{{ __('labels.Name') }}">
                        <div id="name_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="phone">{{ __('labels.Phone') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="phone" name="phone" type="text"
                            placeholder="{{ __('labels.Phone') }}" aria-label="{{ __('labels.Phone') }}">
                        <div id="phone_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="profile_image">{{ __('labels.Profile Image') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="profile_image" name="profile_image" type="file"
                            placeholder="{{ __('labels.Profile Image') }}" aria-label="{{ __('labels.Profile Image') }}" accept=".png, .jpg, .jpeg">
                        <div id="profile_image_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="email">{{ __('labels.Email') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="email" name="email" type="email"
                            placeholder="{{ __('labels.Email') }}" aria-label="{{ __('labels.Email') }}">
                        <div id="email_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="password">{{ __('labels.Password') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="password" name="password" type="text"
                            placeholder="{{ __('labels.Password') }}" aria-label="{{ __('labels.Password') }}">
                        <div id="password_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>


