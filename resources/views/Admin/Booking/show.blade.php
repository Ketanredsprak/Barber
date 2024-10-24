@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">

                    <h4><a class="text-primary" href="{{ route('booking.index') }}" data-bs-toggle="card-remove"><i
                                class="icofont icofont-arrow-left" style="font-size: 1.5em;"></i>
                        </a> {{ __('labels.Booking Detail') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <table style="width:1160px;margin:0 auto;">
            <tbody>
                <tr>
                    <td>
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td><img class="img-fluid for-light"
                                            src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt="">
                                        <address
                                            style="color: #52526C;opacity: 0.8; width: 40%; margin-top: 10px; font-style:normal;">
                                            <span style="font-size: 10px; line-height: 1.5; font-weight: 500;">

                                                @php
                                                    $language = config('app.locale'); // Get current application locale

                                                    $WebsiteConfig = getWebsiteConfig();
                                                    $location = 'location_' . $language;

                                                    echo $WebsiteConfig->$location;
                                                @endphp




                                            </span>
                                        </address>
                                    </td>
                                    <td style="color: #52526C;opacity: 0.8; text-align:end;"><span
                                            style="display:block; line-height: 1.5; font-size:15px; font-weight:500;">{{ __('labels.Email') }}
                                            :
                                            {{ $WebsiteConfig->email }}</span><span
                                            style="display:block; line-height: 1.5; font-size:15px; font-weight:500;">{{ __('labels.Website') }} :
                                            {{ $WebsiteConfig->website_link }}</span><span
                                            style="display:block; line-height: 1.5; font-size:15px; font-weight:500;">{{ __('labels.Contact No') }}
                                            : {{ $WebsiteConfig->phone }} </span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%;">
                            <tbody>
                                <tr
                                    style="display:flex;justify-content:space-between;border-top: 1px solid rgba(82, 82, 108, 0.3);border-bottom: 1px solid rgba(82, 82, 108, 0.3);padding: 25px 0;">
                                    <td style="display:flex;align-items:center; gap: 6px;"> <span
                                            style="color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 500;">{{ __('labels.Booking No.') }}</span>
                                        <h4 style="margin:0;font-weight:400; font-size: 15px;">{{ $bdata->id }}</h4>
                                    </td>
                                    <td style="display:flex;align-items:center; gap: 6px;"> <span
                                            style="color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 500;">{{ __('labels.Date') }} :
                                        </span>
                                        <h4 style="margin:0;font-weight:400; font-size: 15px;">
                                            {{ date('Y-M-d', strtotime($bdata->booking_date)) }}
                                        </h4>
                                    </td>
                                    <td style="display:flex; align-items:center; gap: 6px;">
                                        <span
                                            style="color: #52526C; opacity: 0.8; font-size: 15px; font-weight: 500;">{{ __('labels.Booking Status') }}:</span>
                                        <h4
                                            style="margin:0; font-weight:400; font-size: 15px; padding:6px 15px; border-radius: 5px;">
                                            <?php
                                            // Switch statement to determine badge style and text based on status
                                            switch ($bdata->status) {
                                                case 'pending':
                                                    echo '<span class="badge bg-warning">' . __('labels.Pending') . '</span>';
                                                    break;
                                                case 'reject':
                                                    echo '<span class="badge bg-danger">' . __('labels.Rejected') . '</span>';
                                                    break;
                                                case 'cancel':
                                                    echo '<span class="badge bg-danger">' . __('labels.Cancelled') . '</span>';
                                                    break;
                                                case 'accept':
                                                    echo '<span class="badge bg-success">' . __('labels.Accepted') . '</span>';
                                                    break;
                                                case 'finished':
                                                    echo '<span class="badge bg-primary">' . __('labels.Finished') . '</span>';
                                                    break;
                                                case 'rescheduled':
                                                    echo '<span class="badge bg-warning">' . __('labels.Rescheduled') . '</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-dark">' . __('labels.Unknown') . '</span>';
                                                    break;
                                            }
                                            ?>
                                        </h4>
                                    </td>

                                    {{-- <td style="display:flex;align-items:center; gap: 6px;"> <span
                                        style="color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 500;">Total Amount
                                        :</span>
                                    <h4 style="margin:0;font-weight:500; font-size: 15px;">$26,410.00</h4>
                                </td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;">
                            <tbody>

                                <tr style="width: 100%" style="padding: 28px 0; display:block;">
                                    <td Style="width:50%;">
                                        <span style="color: #52526C;opacity: 0.8; font-size: 16px; font-weight: 500;">{{ __('labels.Barber Details') }} </span>


                                        <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 15px;">

                                            @php
                                                $barberdetails = getuser($bdata->barber_id);

                                            @endphp
                                            @foreach ($barberdetails as $barberdetail)
                                                {{ $barberdetail->first_name . ' ' . $barberdetail->last_name }}

                                        </h4><span
                                            style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">
                                            {{ $barberdetail->location }} </span>

                                        {{-- <span
                                            style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">
                                            {{ $barberdetail->country_name . ' ' . $barberdetail->state_name . ' ' . $barberdetail->city_name }}
                                        </span> --}}
                                        <span
                                            style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">{{ __('labels.Phone') }}
                                            : ( {{ $barberdetail->country_code }} ) {{ $barberdetail->phone }}</span>
                                        @endforeach
                                    </td>
                                    <td style="width: 50%">
                                        <span
                                            style="color: #52526C;opacity: 0.8;font-size: 16px; font-weight: 500;">{{ __('labels.Customer Details') }}</span>
                                        <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 15px;">

                                            @php
                                                $customerdetails = getuser($bdata->user_id);

                                            @endphp
                                            @foreach ($customerdetails as $customerdetail)
                                                {{ $customerdetail->first_name . ' ' . $customerdetail->last_name }}

                                        </h4>
                                        <span
                                            style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">
                                            {{ $customerdetail->location }} </span>

                                        {{-- <span
                                            style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">
                                            {{ $customerdetail->country_name . ' ' . $customerdetail->state_name . ' ' . $customerdetail->city_name }}
                                        </span> --}}
                                        <span
                                            style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 15px; font-weight: 400;">{{ __('labels.Phone') }}
                                            : ( {{ $customerdetail->country_code }} ) {{ $customerdetail->phone }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table
                            style="width: 100%;border-collapse: separate;border-spacing: 0;border: 1px solid rgba(82, 82, 108, 0.1)">
                            <thead>
                                <tr
                                    style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">

                                    {{-- <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">Booking ID</span></th> --}}
                                    <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">{{ __('labels.Service ID') }} </span></th>
                                    <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">{{ __('labels.Service Name') }} </span></th>
                                    <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">{{ __('labels.Price') }} </span></th>
                                    <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">{{ __('labels.Start Time') }} </span></th>
                                    <th style="padding: 15px 15px;text-align: left"><span
                                            style="color: #fff; font-size: 15px;">{{ __('labels.End Time') }} </span></th>

                                </tr>
                            </thead>
                            <tbody>

                                @php $totalAmount=0; @endphp

                                @foreach ($serviceDetails as $serviceDetail)
                                    <tr style="box-shadow: 0px 1px 0px 0px rgba(82, 82, 108, 0.15);">
                                        {{-- <td style="padding: 15px 15px;display:flex;align-items: center;gap: 10px;">
                                            {{ $serviceDetail->booking_id }}</td> --}}
                                        <td style="padding: 15px 15px;"> {{ $serviceDetail->service_id }}</td>

                                        <td style="padding: 15px 15px;">

                                            @php
                                                $language = config('app.locale'); // Get current application locale
                                                $subscription_name = 'service_name_' . $language; // Construct dynamic subscription name key
                                                echo $serviceDetail->$subscription_name;

                                            @endphp
                                        </td>
                                        <td style="padding: 15px 15px;"> @php
                                            $price = $serviceDetail->price;
                                            $totalAmount += $price; // Accumulate total amount
                                        @endphp
                                            {{ $price }} </td>
                                        <td style="padding: 15px 15px;">
                                            {{ date('h:i A', strtotime($serviceDetail->start_time)) }}</td>
                                        <td style="padding: 15px 15px;">
                                            {{ date('h:i A', strtotime($serviceDetail->end_time)) }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="float: right;">
                            <tfoot>
                                <tr>
                                    <td style="padding: 5px 24px 5px 0; padding-top: 15px; text-align: end;"> <span
                                            style="color: #52526C; font-size: 15px; font-weight: 400;">{{ __('labels.Total') }} </span><span
                                            style="margin-left: 8px; font-size: 15px;">:</span></td>
                                    <td style="padding: 5px 0;text-align: left;padding-top: 15px;"><span
                                            style="font-size: 15px;">{{ $bdata->total_price }}.00</span></td>
                                </tr>
                                {{-- <tr>
                                    <td style="padding: 5px 24px 5px 0; text-align: end;"> <span
                                            style="color: #52526C; font-size: 15px; font-weight: 400;">VAT (0%) </span><span
                                            style="margin-left: 8px; font-size: 15px;">:</span></td>
                                    <td style="padding: 5px 0;text-align: left;padding-top: 0;"><span
                                            style="font-size: 15px;">$0.00</span></td>
                                </tr> --}}

                                {{-- <tr>
                                    <td style="padding: 12px 24px 22px 0;"> <span
                                            style="font-weight: 600; font-size: 20px; color: rgba(0, 2, 72, 1);">{{ __('labels.Sub Total') }}</span><span style="margin-left: 8px;">:</span></td>
                                    <td style="padding: 12px 24px 22px 0;;text-align: right"><span
                                            style="font-weight: 500; font-size: 20px; color: rgba(115, 102, 255, 1);">{{ $bdata->total_price }}</span>
                                    </td>
                                </tr> --}}
                            </tfoot>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td> <span
                            style="display:block;background: rgba(82, 82, 108, 0.3);height: 1px;width: 100%;margin-bottom:24px;"></span>
                    </td>
                </tr>
                <tr>
                    <td> <span style="display: flex; justify-content: end; gap: 15px;">
                            <a style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 15px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                href="#!" onclick="history.back();">{{ __('labels.Back') }}<i class="icon-arrow-left"
                                    style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></a>
                            <a style="background: rgba(115, 102, 255, 0.1);color: rgba(115, 102, 255, 1);border-radius: 10px;padding: 15px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                href="{{ route('admin-booking-invoice', $bdata->id) }}">{{ __('labels.Download') }}</a>

                        </span></td>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
