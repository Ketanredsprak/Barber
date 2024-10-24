@extends('Admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="page-title">

            <div class="row">

                <div class="col-6">

                    <h4> {{ __('labels.Bookings') }}</h4>

                </div>

                <!-- <div class="col-6">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"

                                        data-bs-target="#createBookingmodel"><i class="fa fa-plus" aria-hidden="true"></i>

                                        {{ __('labels.Add New') }} </button></li>

                            </ol>

                        </div> -->

            </div>

        </div>

    </div>

    <div class="container-fluid">

        <div class="row">

            <!-- Zero Configuration  Starts-->

            <div class="col-sm-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="display Booking-data">

                                <thead>

                                    <tr>

                                        <th>{{ __('labels.ID') }}</th>

                                        <th>{{ __('labels.Customer Detail') }}</th>

                                        <th>{{ __('labels.Barber Detail') }}</th>

                                        <th>{{ __('labels.Booking Date') }}</th>

                                        {{-- <th>{{ __('labels.Booking Date') }}</th>



                                        <th>{{ __('labels.Start Time') }}</th>

                                        <th>{{ __('labels.End Time') }}</th> --}}

                                        <th>{{ __('labels.Total Price') }}</th>

                                        <th>{{ __('labels.Status') }}</th>

                                        <th>{{ __('labels.Action') }}</th>

                                    </tr>

                                </thead>

                                <tbody>



                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Zero Configuration  Ends-->

        </div>

    </div>

    <!-- Container-fluid Ends-->

    </div>







    <!-- create Booking model --->

    <div class="modal fade" id="createBookingmodel" tabindex="-1" role="dialog" aria-labelledby="createBookingmodel"
        aria-hidden="true">

        @include('Admin.Booking.create')

    </div>

    <!-- create Booking model end --->





    <!-- edit Booking model --->

    <div class="modal fade" id="editBookingmodel" tabindex="-1" role="dialog" aria-labelledby="editBookingmodel"
        aria-hidden="true">

    </div>

    <!-- edit Booking model end --->
@endsection



@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.Booking-data').DataTable({

                processing: true,

                serverSide: true,

                language: {

                    "sProcessing": "{{ __('labels.Processing') }}...",

                    "sLengthMenu": "{{ __('labels.Show') }} _MENU_ {{ __('labels.Entries') }}",

                    "sZeroRecords": "{{ __('labels.No matching records found') }}",

                    "sEmptyTable": "Ningún dato disponible en esta tabla",

                    "sInfo": "{{ __('labels.Showing') }} _START_ {{ __('labels.To') }} _END_ {{ __('labels.Of') }} _TOTAL_ {{ __('labels.Entries') }}",

                    "sInfoEmpty": "{{ __('labels.Showing') }} 0 {{ __('labels.To') }} 0 {{ __('labels.Of') }} 0 {{ __('labels.Entries') }}",

                    "sInfoFiltered": "({{ __('labels.Filtered') }} {{ __('labels.Of') }} _MAX_ {{ __('labels.Entries') }})",

                    "sInfoPostFix": "",

                    "sSearch": "{{ __('labels.Search') }}",

                    "sUrl": "",

                    "sInfoThousands": ",",

                    "sLoadingRecords": "{{ __('labels.Processing') }}...",

                    "oPaginate": {

                        "sFirst": "{{ __('labels.First') }}",

                        "sLast": "{{ __('labels.Last') }}",

                        "sNext": "{{ __('labels.Next') }}",

                        "sPrevious": "{{ __('labels.Previous') }}"

                    },

                    "oAria": {

                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                    }

                },

                // dom: 'lfrtip',

                Booking: {

                    processing: '<i></i><span class="text-primary spinner-border"></span> '

                },

                ajax: "{{ route('booking.index') }}",

                order: [1],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {

                        data: 'user_details',

                        name: 'user_details'

                    },

                    {

                        data: 'barber_details',

                        name: 'barber_details'

                    },

                    {

                        data: 'booking_date_time',

                        name: 'booking_date_time'

                    },


                    // {

                    //     data: 'booking_date',

                    //     name: 'booking_date'

                    // },




                    // {

                    //     data: 'start_time',

                    //     name: 'start_time'

                    // },  {

                    //     data: 'end_time',

                    //     name: 'end_time'

                    // },

                    {

                        data: 'total_price',

                        name: 'total_price'

                    },

                    {

                        data: 'status',

                        name: 'status'

                    },

                    {

                        data: 'action',

                        name: 'action',

                        orderable: false,

                        searchable: false

                    },

                ]

            });





            //delete record

            $(".Booking-data").on('click', '.destroy-data', function(e) {

                e.preventDefault();

                var url = $(this).data('url');

                delete_record(url, table);



            });



            //status-change

            $(".Booking-data").on('click', '.status-change', function(e) {

                e.preventDefault();

                var url = $(this).data('url');

                change_status(url, table);

            });







            //add Booking submit

            $("#Booking-frm").submit(function(event) {

                event.preventDefault();

                var frm = this;

                create_record(frm, table);

            });

            //add Booking submit end





            //get Booking data for edit page

            $(".Booking-data").on('click', '.edit-data', function(e) {

                $.ajax({

                    method: "GET",

                    url: $(this).data('url'),

                    success: function(response) {

                        $('#editBookingmodel').html(response);

                        $('#editBookingmodel').modal('show');

                    },

                    error: function(response) {

                        handleError(response);

                    },

                });

            });

            //get Booking data for edit page end





            //edit Booking

            $(document).on('submit', '#Booking-edit-form', function(e) {

                e.preventDefault();

                var frm = this;

                var url = $(this).attr('action');

                var formData = new FormData(frm);

                formData.append("_method", 'PUT');

                var model_name = "#editBookingmodel";

                edit_record(frm, url, formData, model_name, table);

            });



        });
    </script>
@endsection
