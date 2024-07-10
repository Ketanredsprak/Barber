@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">

                    <h4><a class="text-primary" href="{{ route('customer.index') }}" data-bs-toggle="card-remove"><i
                                class="icofont icofont-arrow-left" style="font-size: 1.5em;"></i>
                        </a> {{ __('labels.Customer Detail') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcustomermodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li> --}}


                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title mb-0">{{ __('labels.Customer Detail') }}</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a></div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-2">
                                    <div class="profile-title">
                                        <div class="media">
                                            <img class="img-70 rounded-circle" alt=""
                                                src="@if (!empty($data->profile_image)) {{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }} @endif">
                                            <div class="media-body">
                                                <h5 class="mb-1">{{ $data->first_name }} {{ $data->last_name }} </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="list-persons">
                                    <div class="profile-mail">
                                        <div class="email-general">
                                            <ul>
                                                <li>{{ __('labels.Email') }} : <span class="font-primary first_name_0">
                                                        {{ $data->email }}</span></li>
                                                <li>{{ __('labels.Phone') }} : <span class="font-primary">
                                                        {{ $data->phone }}</span></li>
                                                <li>{{ __('labels.Gender') }} :<span class="font-primary"> <span
                                                            class="birth_day_0">
                                                            @if ($data->gender == 'Male')
                                                                {{ __('labels.Male') }}
                                                            @else
                                                                {{ __('labels.Female') }}
                                                            @endif
                                                        </span>
                                                </li>
                                                <li>{{ __('labels.Location') }} : <span class="font-primary">
                                                        {{ $data->location }}</span></li>
                                                <li>{{ __('labels.Latitude') }} : <span class="font-primary">
                                                        {{ $data->latitude }}</span></li>
                                                <li>{{ __('labels.Longitude') }} : <span class="font-primary">
                                                        {{ $data->longitude }}</span></li>
                                                <li>{{ __('labels.Register Type') }} :

                                                    <span class="font-primary">
                                                        @if ($data->register_type == "1")
                                                            {{ __('labels.App') }}
                                                        @else
                                                            {{ __('labels.Web') }}
                                                        @endif
                                                    </span>
                                                </li>
                                                <li>{{ __('labels.Register Method') }} :
                                                    <span class="font-primary">
                                                        @if ($data->register_method == "1")
                                                            {{ __('labels.System') }}
                                                        @elseif($data->register_method == "2")
                                                            {{ __('labels.Facebook') }}
                                                        @elseif($data->register_method == "2")
                                                            {{ __('labels.Google') }}
                                                        @else
                                                            {{ __('labels.Apple') }}
                                                        @endif
                                                    </span>
                                                </li>
                                                </li>


                                                <li>{{ __('labels.Customer Status') }} :<span class="font-primary mobile_num_0">
                                                        @if ($data->is_approved == 1)
                                                            <span class="badge bg-primary">{{ __('labels.Pending') }}</span>
                                                        @elseif($data->is_approved == 2)
                                                            <span class="badge bg-success">{{ __('labels.Approved') }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ __('labels.Suspend') }}</span>
                                                        @endif
                                                </li>

                                                <li>{{ __('labels.Referral Code') }} :<span
                                                        class="font-primary city_0">{{ $data->referral_code }}</span></li>
                                                <li>{{ __('labels.Joining Date') }} :<span
                                                        class="font-primary personality_0">{{ $data->created_at }}</span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                     <div class="card">
                        {{-- <div class="card-header pb-0 card-no-border">
                          <h4>Customer Booking Record</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="display" id="basic-9">
                              <thead>
                                <tr>
                                  <th>Barber Detail</th>
                                  <th>Appoinment Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><div class="media"><img class="b-r-8 img-40" src='http://localhost/Barber/public//admin/assets/images/user/user.png'>
                                    <div class="media-body">
                                      <div class="row">
                                        <div class="col-xl-12">
                                        <h6 class="mt-0">&nbsp;&nbsp; Demo Barber</span></h6>
                                        </div>
                                      </div>
                                      <p>&nbsp;&nbsp; Barber@mailinator.com</p>
                                    </div>
                                  </div>
                                 </td>
                                  <td>2011/04/25</td>
                                  <td><span class="badge rounded-pill badge-light-success">Complete</span></td>
                                  <td>
                                    <ul class="action">
                                      <li class="show"> <a href="#"><i class="icon-eye"></i></a></li>
                                    </ul>
                                  </td>
                                </tr>

                                <tr>
                                    <td><div class="media"><img class="b-r-8 img-40" src='http://localhost/Barber/public//admin/assets/images/user/user.png'>
                                      <div class="media-body">
                                        <div class="row">
                                          <div class="col-xl-12">
                                          <h6 class="mt-0">&nbsp;&nbsp; Demo Barber</span></h6>
                                          </div>
                                        </div>
                                        <p>&nbsp;&nbsp; Barber@mailinator.com</p>
                                      </div>
                                    </div>
                                   </td>
                                    <td>2011/04/25</td>
                                    <td><span class="badge rounded-pill badge-light-success">Pending</span></td>
                                    <td>
                                      <ul class="action">
                                        <li class="show"> <a href="#"><i class="icon-eye"></i></a></li>
                                      </ul>
                                    </td>
                                  </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <th>Barber Detail</th>
                                    <th>Appoinment Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div> --}}

                        <div class="card-body">
                        Comming Soon
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->





    </div>
@endsection
