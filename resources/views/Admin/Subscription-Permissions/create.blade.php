<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Permission') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('subscription-permission.store') }}"
                id="subpermission-frm">
                @csrf
                <div class="row g-2">

                    <div class="col-md-4">
                        <label class="form-label"
                            for="validationServer01">{{ __('labels.Permission For User') }}</label>
                        <select class="form-select permission_for_user" name="permission_for_user"
                            id="permission_for_user">
                            <option value="barber">{{ __('labels.Barber') }}</option>
                            <option value="customer">{{ __('labels.Customer') }}</option>
                        </select>
                        <div id="permission_for_user_error" style="display: none;" class="text-danger"></div>
                    </div>


                    <div class="col-md-8">
                        <label class="form-label">Select Subscription<span class="text-danger">*</span></label>
                        <select name="subscription_id[]" aria-label="Select a Subscription" id="subscription_id"
                            class="form-select custom_select2 js-example-basic-multiple SubscriptionData" multiple>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label" for="permission_name">{{ __('labels.Permission Key') }} <span
                                class="text-danger">*</span> </label>
                        <input class="form-control" id="permission_name" name="permission_name" type="text"
                            placeholder="{{ __('labels.Permission Key') }}">
                        <div id="permission_name_error" style="display: none;" class="text-danger custom-error">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check checkbox-checked">
                            <label class="form-label" for="is_input_box">{{ __('labels.Input Box') }} <span
                                    class="text-danger">*</span> </label><br>
                            <input class="form-check-label" id="is_input_box" name="is_input_box" type="checkbox"
                                value="1">
                            <label class="form-check-label" for="gridCheck1">{{ __('labels.Input Box') }}</label>

                        </div>
                    </div>


                    <div id="additional-input" class="d-none row">

                        <div class="col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Basic Subscription') }}</label>
                            {{-- <input class="form-control" id="basic" name="basic" type="text"
                                placeholder="{{ __('labels.Permission Key') }}"> --}}

                                <input class="form-control" id="sub_basic" name="sub_basic" type="text"
                                placeholder="{{ __('labels.Permission Key') }}">

                            <div id="basic_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Bronz Subscription') }}</label>
                            <input class="form-control" id="sub_bronz" name="sub_bronz" type="text"
                                placeholder="{{ __('labels.Permission Key') }}">
                            <div id="bronz_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Silver Subscription') }}</label>
                            <input class="form-control" id="sub_silver" name="sub_silver" type="text"
                                placeholder="{{ __('labels.Permission Key') }}">
                            <div id="silver_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Gold Subscription') }}</label>
                            <input class="form-control" id="sub_gold" name="sub_gold" type="text"
                                placeholder="{{ __('labels.Permission Key') }}">
                            <div id="gold_error" style="display: none;" class="text-danger"></div>
                        </div>
                    </div>



                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subpermissionSubmit"><i
                        class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
