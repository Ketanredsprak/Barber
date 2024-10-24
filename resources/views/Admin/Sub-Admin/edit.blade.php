<div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Sub Admin') }}</h5>

            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>

        </div>

        <div class="modal-body" id="myModal">

            <form class="form-bookmark" method="post" action="{{ route('subadmin.update', $data->id) }}" id="subadmin-edit-form">

                @csrf

                <div class="row g-2">





                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="first_name">{{ __('labels.First Name') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="first_name" name="first_name" type="text"

                            placeholder="{{ __('labels.First Name') }}" aria-label="{{ __('labels.First Name') }}" value="{{ $data->first_name}}">

                        <div id="first_name_error" style="display: none;" class="text-danger"></div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="last_name">{{ __('labels.Last Name') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="last_name" name="last_name" type="text"

                            placeholder="{{ __('labels.Last Name') }}" aria-label="{{ __('labels.Last Name') }}" value="{{ $data->last_name}}">

                        <div id="last_name_error" style="display: none;" class="text-danger"></div>

                    </div>





                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="phone">{{ __('labels.Phone') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="phone" name="phone" type="text" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"

                        placeholder="{{ __('labels.Phone') }}" aria-label="{{ __('labels.Phone') }}"  value="{{ $data->phone }}">

                        <div id="phone_error" style="display: none;" class="text-danger"></div>

                    </div>





                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="email">{{ __('labels.Email') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="email" name="email" type="text"

                            placeholder="{{ __('labels.Email') }}" aria-label="{{ __('labels.Email') }}" value="{{ $data->email}}" readonly=""  readonly>

                        <div id="email_error" style="display: none;" class="text-danger"></div>

                    </div>



                    <div class="col-sm-4">

                        <label class="form-label" for="profile_image">{{ __('labels.Profile Image') }} (Accept:png,jpg,jpeg) <span class="text-danger">*</span> </label>

                        <input class="form-control" id="profile_image" type="file" name="profile_image"

                            accept=".png, .jpg, .jpeg">

                    </div>

                    <div class="col-sm-2">

                        <label class="form-label" for="profile_image"></label><br>

                        <img src="@if(!empty($data->profile_image)){{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" class=""

                            style="height:30px; width:30px;">

                    </div>





                    <div class="col-sm-6">

                        <label class="form-label"> {{ __('labels.Gender') }} <span class="text-danger">*</span></label>

                        <select name="gender" aria-label="{{ __('labels.Select a Gender') }}"

                            data-placeholder="{{ __('labels.Select a Gender') }}" class="form-select">

                            <option value=""> {{ __('labels.Select a Gender') }}</option>

                            <option value="Male"  @if ($data->gender == 'Male') selected = "selected" @endif>{{ __('labels.Male') }}</option>

                            <option value="Female"  @if ($data->gender == 'Female') selected = "selected" @endif>{{ __('labels.Female') }}</option>

                        </select>

                    </div>



                </div>

                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="adminSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"

                    id="is_close">{{ __('labels.Close') }}</button>

            </form>

        </div>

    </div>

</div>

