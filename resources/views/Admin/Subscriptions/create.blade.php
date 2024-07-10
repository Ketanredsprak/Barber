@extends('Admin.layouts.app')
@section('content')
    <?php
    $url = URL::to('admin/subscription');
    $barbers = getbarbers();
    ?>
    <div class="container-fluid">
        <div class="page-title">

        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>{{ __('labels.Add Subscription') }}</h4>
                    </div>
                    <div class="card-body custom-input">
                        <form class="form-bookmark" method="post" action="{{ route('subscription.store') }}"
                            id="subscription-frm">
                            @csrf
                            <div class="row g-2">

                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="subscription_name_en">{{ __('labels.Subscription English Name') }}
                                        <span class="text-danger">*</span> </label>
                                    <input class="form-control" id="subscription_name_en" name="subscription_name_en"
                                        type="text" placeholder="{{ __('labels.Subscription English Name') }}"
                                        aria-label="{{ __('labels.Subscription English Name') }}">
                                    <div id="subscription_name_en_error" style="display: none;" class="text-danger"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="subscription_name_ar">{{ __('labels.Subscription Arabic Name') }}
                                        <span class="text-danger">*</span> </label>
                                    <input class="form-control" id="subscription_name_ar" name="subscription_name_ar"
                                        type="text" placeholder="{{ __('labels.Subscription Arabic Name') }}"
                                        aria-label="{{ __('labels.Subscription Arabic Name') }}">
                                    <div id="subscription_name_ar_error" style="display: none;" class="text-danger"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">{{ __('labels.Subscription English Description') }}<span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <textarea class="form-control" id="subscription_description_en" name="subscription_description_en" rows="5"></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">{{ __('labels.Subscription Arabic Description') }}<span class="text-danger">*</span></span>
                                    </label>
                                    <textarea class="form-control" id="subscription_description_ar" name="subscription_description_ar" rows="5"></textarea>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="subscription_name_ur">{{ __('labels.Subscription Urdu Name') }} <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control" id="subscription_name_ur" name="subscription_name_ur"
                                        type="text" placeholder="{{ __('labels.Subscription Urdu Name') }}"
                                        aria-label="{{ __('labels.Subscription Urdu Name') }}">
                                    <div id="subscription_name_ur_error" style="display: none;" class="text-danger"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="subscription_name_tr">{{ __('labels.Subscription Turkish Name') }}
                                        <span class="text-danger">*</span> </label>
                                    <input class="form-control" id="subscription_name_tr" name="subscription_name_tr"
                                        type="text" placeholder="{{ __('labels.Subscription Turkish Name') }}"
                                        aria-label="{{ __('labels.Subscription Turkish Name') }}">
                                    <div id="subscription_name_tr_error" style="display: none;" class="text-danger"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">{{ __('labels.Subscription Urdu Description') }}<span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <textarea class="form-control" id="subscription_description_ur" name="subscription_description_ur" rows="5"></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">{{ __('labels.Subscription Turkish Description') }}<span
                                                class="text-danger">*</span></span>
                                    </label>
                                    <textarea class="form-control" id="subscription_description_tr" name="subscription_description_tr" rows="5"></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="price">{{ __('labels.Price') }} <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control" id="price" name="price" type="text"
                                        placeholder="{{ __('labels.Price') }}" aria-label="{{ __('labels.Price') }}">
                                    <div id="price_error" style="display: none;" class="text-danger"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="number_of_booking">{{ __('labels.Number Of Booking') }} <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control" id="number_of_booking" name="number_of_booking"
                                        type="text" placeholder="{{ __('labels.Number Of Booking') }}"
                                        aria-label="{{ __('labels.Number Of Booking') }}">
                                    <div id="number_of_booking_error" style="display: none;" class="text-danger"></div>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label" for="duration">{{ __('labels.Duration (in-Days)') }} <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control" id="duration_in_days" name="duration_in_days"
                                        type="text" placeholder="{{ __('labels.Duration (in-Days)') }}"
                                        aria-label="{{ __('labels.Duration (in-Days)') }}">
                                    <div id="duration_error" style="display: none;" class="text-danger"></div>
                                </div>


                                <div class="col-sm-6">
                                    <label class="form-label">{{ __('labels.Subscription Type') }}</label>
                                    <select name="subscription_type" id="subscription_type" aria-label="{{ __('labels.Subscription Type') }}"
                                        data-placeholder="{{ __('labels.Subscription Type') }}..." class="form-select">
                                        <option value="">{{ __('labels.Subscription Type') }}</option>
                                        <option value="barber">{{ __('labels.Barber') }}</option>
                                        <option value="customer">{{ __('labels.Customer') }}</option>
                                    </select>
                                </div>




                            </div>
                            <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subscriptionSubmit"><i
                                    class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                            {{-- <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                                id="is_close">{{ __('labels.Close') }}</button> --}}

                                <a href="{{ route('subscription.index') }}" class="btn btn-light">{{ __('labels.Close') }}</a>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', '#subscription-frm', function(e) {
                e.preventDefault();
                var frm = this;
                var btn = $('#subscriptionSubmit');
                var url = $(this).attr('action');
                var formData = new FormData(frm);

                // for button
                jQuery('.btn-custom').addClass('disabled');
                jQuery('.icon').removeClass('d-none');


                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        show_toster(response.success)
                        frm.reset();

                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');

                        var content = "{{ $url }}";

                        window.setTimeout(function() {
                            window.location.href = content;
                        }, 300);


                        // location.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            toastr.error(value);

                        });
                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');

                    },
                });

            });
        });

    </script>
@endsection
