<?php
$language = config('app.locale');
$service_name = 'service_name_' . $language;
if (empty($data->barber_detail->profile_image)) {
    $profile_image = 'default.png';
} else {
    $profile_image = $data->barber_detail->profile_image;
}
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">{{ __('labels.View Booking Detail') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body modal_body">
            <h4 class="view-title">{{ $data->barber_detail->first_name }} {{ $data->barber_detail->last_name }} -
                {{ $data->barber_detail->salon_name }}</h4>
            <div class="modal_view_img mb-3">
                <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid" alt="modal">
            </div>
            <div class="modal_info">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-lg-9">
                        <ul class="list-unstyled available_info mt-3 p-0">
                            <li> <i><img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"></i><span>
                                    {{ $data->barber_detail->location }} </span></li>
                            <li> <i><img src="{{ static_asset('frontend/assets/images/Star-2.png') }}"></i><span> 4.5
                                </span></li>
                        </ul>


                        @if ($data->booking_type == 'booking')
                        <ul class="list-unstyled available_info mt-3 p-0">
                            <li> <i><img src="{{ static_asset('frontend/assets/images/calender.png') }}"></i><span>
                                <h4 class="view-title"> &nbsp;&nbsp;{{ __('labels.Date & Time') }}</h4>
                              </span></li>
                          </ul>

                          <p class="mt-0"> {{ date('d-M-Y', strtotime($data->booking_date)) }}
                            {{ date('h:i A', strtotime($data->booking_service_detailss[0]->start_time)) }}</p>
                            
                        @endif


                        

                        <h4 class="view-title"> {{ __('labels.Service List') }}</h4>



                        @if ($data->booking_service_detailss)

                            @foreach ($data->booking_service_detailss as $service)
                                <div class="service_box">
                                    <div class="user_model">
                                            <img src="{{ static_asset('service_image/' . $service->sub_service->service_image) }}"
                                                class="img-fluid" alt="review">
                                        <div class="service_model mt-3">
                                            <h5>{{ $service->main_service->$service_name }}</h5>
                                            <p>{{ $service->sub_service->$service_name }}</p>
                                            <p>${{ $service->price }}.00 </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif



                        <h4 class="view-title">{{ __('labels.Status') }} :
                            @if ($data->status == 'pending')
                                {{ __('labels.Pending') }}
                            @elseif ($data->status == 'cancel')
                                {{ __('labels.Cancel') }}
                            @elseif($data->status == 'reject')
                                {{ __('labels.Reject') }}
                            @elseif($data->status == 'accept')
                                {{ __('labels.Accept') }}
                            @elseif($data->status == 'finished')
                                {{ __('labels.Finished') }}
                            @elseif($data->status == 'rescheduled')
                                {{ __('labels.Rescheduled') }}
                            @endif
                        </h4>





                        <h4 class="view-title"> {{ __('labels.Payment summary (Paid at salon)') }} </h4>

                        <div class="pt-3">
                            @if ($data->booking_service_detailss)

                                @foreach ($data->booking_service_detailss as $service)
                                    <div class="d-flex justify-content-between mb-1 ">
                                        <span>{{ $service->$service_name }}</span> <span>${{ $service->price }}</span>
                                    </div>
                                @endforeach



                            @endif
                            <hr>
                            <div class="d-flex justify-content-between mb-4 ">
                                <span>{{ __('labels.Total Price') }}</span> <strong
                                    class="text-dark">${{ $data->total_price }}</strong>
                            </div>

                        </div>
                        <a class="btn btn-success" type="submit" href="{{ route('get-booking-page', $barber_id) }}">{{ __('labels.Book Again') }}</a>


                    </div>
                </div>


            </div>


        </div><!-- modal-content -->
    </div>
</div>
