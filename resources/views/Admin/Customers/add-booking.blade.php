    @php
        if (empty($data->profile_image)) {
            $profile_image = 'default.png';
        } else {
            $profile_image = $data->profile_image;
        }
    @endphp
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="media d-flex align-items-center">
                    <!-- Improved image styling -->
                    <div class="media-size-email">
                        <img class="me-3 rounded-circle"
                            src="{{ static_asset('profile_image/' . $profile_image) }}"
                            alt="Profile Image" style="height: 40px; width: 40px;">
                    </div>
                    <div class="media-body">
                        <!-- Ensuring name and email are displayed correctly -->
                        <h6 class="fw-bold mb-0">{{ $data->first_name }} {{ $data->last_name }}</h6>
                        <p class="mb-0">{{ $data->email }} </p>
                    </div>
                </div>
                <!-- Close button with correct functionality -->
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                    onclick="return close_or_clear();"></button>
            </div>
            <div class="modal-body" id="myModal">
                <form class="form-bookmark" method="post" action="{{ route('customer.booking.save') }}" id="customer-booking-frm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2">
                        <div class="mb-3 col-md-12">
                            <input class="form-control" id="user_id" name="user_id" type="hidden"
                               value="{{ $data->id}}">
                            <label class="form-label" for="number_of_booking">{{ __('labels.Number of Booking') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="number_of_booking" name="number_of_booking" type="text"
                                placeholder="{{ __('labels.Number of Booking') }}" aria-label="{{ __('labels.Number of Booking') }}">
                            <div id="number_of_booking_error" style="display: none;" class="text-danger"></div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit">
                        <i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}
                    </button>
                    <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal" id="is_close">
                        {{ __('labels.Close') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
