@extends('Admin.layouts.app')
@section('content')
    @php
        $locale = Illuminate\Support\Facades\App::getLocale();
        $name = 'name_' . $locale;
    @endphp

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ __('labels.System Notifications') }}</h4>




                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        @if (auth()->user()->can('notification-create'))
                            <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button"
                                    data-bs-toggle="modal" data-bs-target="#createservicemodel"><i class="fa fa-plus"
                                        aria-hidden="true"></i>
                                    {{ __('labels.Add New') }} </button></li>
                        @endif


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
                            <table class="display service-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>{{ __('labels.User Type') }}</th>
                                        <th>{{ __('labels.Notification Type') }}</th>
                                        <th>{{ __('labels.Title') }}</th>
                                        <th>{{ __('labels.Description') }}</th>
                                        <th>{{ __('labels.Created At') }}</th>
                                        <!-- <th>{{ __('labels.Action') }}</th> -->
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



    <!-- create service model --->
    <div class="modal fade" id="createservicemodel" tabindex="-1" role="dialog" aria-labelledby="createservicemodel"
        aria-hidden="true">
        @include('Admin.System-Notification.create')
    </div>
    <!-- create service model end --->


    <!-- edit service model --->
    <div class="modal fade" id="editservicemodel" tabindex="-1" role="dialog" aria-labelledby="editservicemodel"
        aria-hidden="true">
    </div>
    <!-- edit service model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.service-data').DataTable({
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
                service: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('SystemNotification.index') }}",
                order: [1],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'usertype',
                        name: 'usertype'
                    },

                    {
                        data: 'notificationtype',
                        name: 'notificationtype'
                    },

                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    // {
                    //     data: 'status',
                    //     name: 'status'
                    // },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });


            //delete record
            $(".service-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".service-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add service submit
            $("#service-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add service submit end


            //get service data for edit page
            $(".service-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editservicemodel').html(response);
                        $('#editservicemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get service data for edit page end


            //edit service
            $(document).on('submit', '#service-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editservicemodel";
                edit_record(frm, url, formData, model_name, table);
            });


        });
    </script>
@endsection
