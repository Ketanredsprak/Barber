@extends('Admin.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="page-title">

            <div class="row">

                <div class="col-6">

                    <h4>{{ __('labels.Customers') }}</h4>

                </div>

                <div class="col-6">

                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"

                                data-bs-target="#createcustomermodel"><i class="fa fa-plus" aria-hidden="true"></i>

                                {{ __('labels.Add New') }}</button></li> --}}

                    </ol>

                </div>

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

                            <table class="display customer-data">

                                <thead>

                                    <tr>

                                        <th>{{ __('labels.ID') }}</th>

                                        <th>{{ __('labels.Customer Detail') }}</th>

                                        <th>{{ __('labels.Phone') }}</th>

                                        <th>{{ __('labels.Subscriptions') }}</th>

                                        <th>{{ __('labels.Subscriptions Start') }}</th>

                                        <th>{{ __('labels.Subscriptions End') }}</th>

                                        {{-- <th>{{ __('labels.Joing Date') }}</th> --}}

                                        <th>{{ __('labels.availble_booking') }}</th>

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







    <!-- create customer model --->

    <div class="modal fade" id="createcustomermodel" tabindex="-1" role="dialog" aria-labelledby="createcustomermodel"

        aria-hidden="true">

        @include('Admin.Customers.create')

    </div>

    <!-- create customer model end --->





    <!-- edit customer model --->

    <div class="modal fade" id="editcustomermodel" tabindex="-1" role="dialog" aria-labelledby="editcustomermodel"

        aria-hidden="true">

    </div>

    <!-- edit customer model end --->



    <!-- add booking to customer model --->

    <div class="modal fade" id="addbookingmodel" tabindex="-1" role="dialog" aria-labelledby="addbookingmodel"

        aria-hidden="true">

    </div>

    <!-- add booking to customer model end --->

@endsection



@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            var table = $('.customer-data').DataTable({

                processing: true,

                serverSide: true,

                language: {

                    "sProcessing": "{{ __('labels.Processing') }}...",

                    "sLengthMenu": "{{ __('labels.Show') }} _MENU_ {{ __('labels.Entries') }}",

                    "sZeroRecords": "{{ __('labels.No matching records found') }}",

                    "sEmptyTable": "{{ __('labels.No records found') }}",

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

                customer: {

                    processing: '<i></i><span class="text-primary spinner-border"></span> '

                },

                ajax: "{{ route('customer.index') }}",

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

                        data: 'phone',

                        name: 'phone'

                    },

                    {

                        data: 'subscriptions_name',

                        name: 'subscriptions_name'

                    },

                    {

                        data: 'subscriptions_start_date',

                        name: 'subscriptions_start_date'

                    },

                    {

                        data: 'subscriptions_end_date',

                        name: 'subscriptions_end_date'

                    },

                    // {

                    //     data: 'joing_date',

                    //     name: 'joing_date'

                    // },

                    {

                        data: 'availble_booking',

                        name: 'availble_booking'

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

            $(".customer-data").on('click', '.destroy-data', function(e) {

                e.preventDefault();

                var url = $(this).data('url');

                delete_record(url, table);



            });



            //status-change

            $(".customer-data").on('click', '.status-change', function(e) {

                e.preventDefault();

                var url = $(this).data('url');

                change_status(url, table);

            });







            //add customer submit

            $("#customer-frm").submit(function(event) {

                event.preventDefault();

                var frm = this;

                create_record(frm, table);

            });

            //add customer submit end





            //get customer data for edit page

            $(".customer-data").on('click', '.edit-data', function(e) {

                $.ajax({

                    method: "GET",

                    url: $(this).data('url'),

                    success: function(response) {

                        $('#editcustomermodel').html(response);

                        $('#editcustomermodel').modal('show');

                    },

                    error: function(response) {

                        handleError(response);

                    },

                });

            });

            //get customer data for edit page end





            //edit customer

            $(document).on('submit', '#customer-edit-form', function(e) {

                e.preventDefault();

                var frm = this;

                var url = $(this).attr('action');

                var formData = new FormData(frm);

                formData.append("_method", 'PUT');

                var model_name = "#editcustomermodel";

                edit_record(frm, url, formData, model_name, table);

            });









            //add booking to customer

            $(".customer-data").on('click', '.booking-add-data', function(e) {

                $.ajax({

                    method: "GET",

                    url: $(this).data('url'),

                    success: function(response) {

                        $('#addbookingmodel').html(response);

                        $('#addbookingmodel').modal('show');

                    },

                });

            });

            // add booking to customer





            // add booking to customer

            $(document).on('submit', '#customer-booking-frm', function(e) {

                e.preventDefault();

                var frm = this;

                var url = $(this).attr('action');

                var formData = new FormData(frm);

                formData.append("_method", 'POST');

                var model_name = "#addbookingmodel";





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

                        $(model_name).modal('hide');

                        show_toster(response.success)

                        table.draw();

                        frm.reset();

                        jQuery('.btn-custom').removeClass('disabled');

                        jQuery('.icon').addClass('d-none');

                    },

                    error: function(xhr) {

                        // $('#send').button('reset');

                        var errors = xhr.responseJSON;

                        $.each(errors.errors, function(key, value) {

                            var ele = "#" + key;

                            toastr.error(value);

                            jQuery('.btn-custom').removeClass('disabled');

                            jQuery('.icon').addClass('d-none');

                        });

                    },

                });



            });





        });

    </script>

@endsection

