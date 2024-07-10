<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Subscription Permission') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('subscription-permission.update', $data->id) }}"
                id="subpermission-edit-form">
                @csrf
                <div class="row g-2">



                    <div class="g-2 col-md-4">
                        <label class="form-label"
                            for="validationServer01">{{ __('labels.Permission For User') }}</label>
                        <select class="form-select permission_for_user" name="permission_for_user"
                            id="permission_for_user">
                            <option value="barber" @if($data->permission_for_user == "barber") selected = "" @endif>{{ __('labels.Barber') }}</option>
                            <option value="customer" @if($data->permission_for_user == "customer") selected = "" @endif>{{ __('labels.Customer') }}</option>
                        </select>
                        <div id="permission_for_user_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <?php $subscription_list = getSubscription($data->permission_for_user); ?>
                    <div class="g-2 col-md-8">
                        <label class="form-label">Select Subscription <span
                                class="text-danger">*</span></label>
                        <select name="subscription_id[]" id="subscription_id"
                            class="form-select custom_select2 categoryData subscription_id" multiple>
                                 @foreach ($subscription_list as $subscription)
                                      @php
                                     $locale = config('app.locale');
                                     $subscription_name = "subscription_name_".$locale;
                                        if (!empty($subscription)) {
                                            $name = $subscription->$subscription_name;
                                        } else {
                                            $name = 'No Data Found';
                                        }
                                    @endphp
                                    <option value="{{ $subscription['id'] }}"
                                        @if ($data->subscription_array != null) @if (in_array($subscription['id'], $data->subscription_array)) selected @endif
                                        @endif> {{ $name }}</option>
                                @endforeach

                        </select>
                    </div>


                    <div class="g-2 col-md-8">
                        <label class="form-label" for="permission_name">{{ __('labels.Permission Key') }} <span
                                class="text-danger">*</span> </label>
                        <input class="form-control" id="permission_name" name="permission_name" type="text"
                            placeholder="{{ __('labels.Permission Key') }}" value="{{ $data->permission_detail }}">
                        <div id="permission_name_error" style="display: none;" class="text-danger custom-error">
                        </div>
                    </div>


                    <div class="g-2 col-md-4">
                        <div class="form-check checkbox-checked">
                            <label class="form-label" for="is_input_box">{{ __('labels.Input Box') }} <span
                                    class="text-danger">*</span> </label><br>
                            <input class="form-check-label" id="is_input_box_edit" name="is_input_box_edit" type="checkbox"
                                value="1" @if($data->is_input_box == 1) checked @endif>
                            <label class="form-check-label" for="gridCheck1">{{ __('labels.Input Box') }}</label>

                        </div>
                    </div>


                    <div id="additional-input-edit" class="@if($data->is_input_box == 0) d-none @endif row">

                        <div class="g-2 col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Basic Subscription') }}</label>
                                <input class="form-control" id="sub_basic" name="sub_basic" type="text"
                                placeholder="{{ __('labels.Permission Key') }}" value="{{ $data->basic_input_value }}">
                                <div id="basic_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="g-2 col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Bronz Subscription') }}</label>
                            <input class="form-control" id="sub_bronz" name="sub_bronz" type="text"
                                placeholder="{{ __('labels.Permission Key') }}"  value="{{ $data->bronz_input_value }}">
                            <div id="bronz_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="g-2 col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Silver Subscription') }}</label>
                            <input class="form-control" id="sub_silver" name="sub_silver" type="text"
                                placeholder="{{ __('labels.Permission Key') }}"  value="{{ $data->silver_input_value }}">
                            <div id="silver_error" style="display: none;" class="text-danger"></div>
                        </div>


                        <div class="g-2 col-md-6">
                            <label class="form-label"
                                for="validationServer01">{{ __('labels.Gold Subscription') }}</label>
                            <input class="form-control" id="sub_gold" name="sub_gold" type="text"
                                placeholder="{{ __('labels.Permission Key') }}"  value="{{ $data->gold_input_value }}">
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
<script>
$('.custom_select2').select2({
    // dropdownParent: $('#createsubscriptionmodel')
});


$('#is_input_box_edit').change(function() {
            if ($(this).is(':checked')) {
                $('#additional-input-edit').removeClass('d-none');
            } else {
                $('#additional-input-edit').addClass('d-none');
            }
        });
</script>

