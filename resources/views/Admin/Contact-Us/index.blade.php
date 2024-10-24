@extends('Admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="page-title">

            <div class="row">

                <div class="col-6">

                    <h4> {{ __('labels.Customer Inquirys') }}</h4>

                </div>

                <div class="col-6">

                    <ol class="breadcrumb">







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

                            <table class="display contact-data" id="">

                                <thead>

                                    <tr>

                                        <th>{{ __('labels.ID') }}</th>

                                        <th>{{ __('labels.First Name') }}</th>

                                        <th>{{ __('labels.Last Name') }} </th>

                                        <th>{{ __('labels.Email') }}</th>

                                        <th>{{ __('labels.Subject') }}</th>

                                        <th>{{ __('labels.Created At') }}</th>

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



    <!-- show model --->

    <div class="modal fade" id="showcontactusmodel" tabindex="-1" role="dialog" aria-labelledby="showcontactusmodel"
        aria-hidden="true">

    </div>

    <!-- show model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.contact-data').DataTable({

                processing: true,

                serverSide: true,

                // dom: 'lfrtip',

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

                ajax: "{{ route('contact-us.index') }}",

                order: [1],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {

                        data: 'first_name',

                        name: 'first_name'

                    },

                    {

                        data: 'last_name',

                        name: 'last_name'

                    },

                    {

                        data: 'email',

                        name: 'email'

                    },

                    {

                        data: 'subject',

                        name: 'subject'

                    },

                    {

                        data: 'created_at',

                        name: 'created_at'

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

            $(".contact-data").on('click', '.destroy-data', function(e) {

                e.preventDefault();

                var url = $(this).data('url');

                delete_record(url, table);



            });





            //get cms data for Show page

            $(".contact-data").on('click', '.show-data', function(e) {

                $.ajax({

                    method: "GET",

                    url: $(this).data('url'),

                    success: function(response) {

                        $('#showcontactusmodel').html(response);

                        $('#showcontactusmodel').modal('show');

                    },

                    error: function(response) {

                        handleError(response);

                    },

                });

            });

            //get cms data for Show page end



        });
    </script>
@endsection
