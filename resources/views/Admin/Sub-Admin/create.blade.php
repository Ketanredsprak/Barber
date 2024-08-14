<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Sub Admin') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('subadmin.store') }}" id="subadmin-frm">
                @csrf
                <div class="row g-2">


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="first_name">{{ __('labels.First Name') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="first_name" name="first_name" type="text"
                            placeholder="{{ __('labels.First Name') }}" aria-label="{{ __('labels.First Name') }}">
                        <div id="first_name_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="last_name">{{ __('labels.Last Name') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="last_name" name="last_name" type="text"
                            placeholder="{{ __('labels.Last Name') }}" aria-label="{{ __('labels.Last Name') }}">
                        <div id="last_name_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="phone">{{ __('labels.Phone') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="phone" name="phone" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        placeholder="{{ __('labels.Phone') }}" aria-label="{{ __('labels.Phone') }}">
                        <div id="phone_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="email">{{ __('labels.Email') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="email" name="email" type="text"
                            placeholder="{{ __('labels.Email') }}" aria-label="{{ __('labels.Email') }}">
                        <div id="email_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="profile_image">{{ __('labels.Profile Image') }}  ({{ __('labels.Accept:png,jpg,jpeg') }})<span class="text-danger">*</span> </label>
                        <input class="form-control" id="profile_image" name="profile_image" type="file"
                            placeholder="{{ __('labels.Profile Image') }}" aria-label="{{ __('labels.Profile Image') }}" accept=".png, .jpg, .jpeg">
                        <div id="profile_image_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label"> {{ __('labels.Gender') }} <span class="text-danger">*</span></label>
                        <select name="gender" aria-label="{{ __('labels.Select a Gender') }}"
                            data-placeholder="{{ __('labels.Select a Gender') }}" class="form-select">
                            <option value=""> {{ __('labels.Select a Gender') }}</option>
                            <option value="Male">{{ __('labels.Male') }}</option>
                            <option value="Female">{{ __('labels.Female') }}</option>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="password">{{ __('labels.Password') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" type="password" placeholder="{{ __('labels.Password') }}"  autocomplete="off">
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="confirm_password"> {{ __('labels.Confirm Password') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password"
                            name="confirm_password" type="password" placeholder="{{ __('labels.Confirm Password') }} "  autocomplete="off">
                    </div>




                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="adminSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
