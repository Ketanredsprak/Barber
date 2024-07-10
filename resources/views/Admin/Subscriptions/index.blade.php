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
                    <h4>{{ __('labels.Subscriptions') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="btn btn-sm btn-primary" type="button"
                                href="{{ route('subscription.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>
                                {{ __('labels.Add New') }} </a></li>
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
                            <table class="display subscription-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>{{ __('labels.Subscription Name') }} </th>
                                        <th>{{ __('labels.Subscription Price') }} </th>
                                        <th>{{ __('labels.Number of Booking') }} </th>
                                        <th>{{ __('labels.Subscription Type') }} </th>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.subscription-data').DataTable({
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
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('subscription.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'subscription_name',
                        name: 'subscription_name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'number_of_booking',
                        name: 'number_of_booking'
                    },
                    {
                        data: 'subscription_type',
                        name: 'subscription_type'
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
            $(".subscription-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".subscription-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



        });
    </script>
@endsection
