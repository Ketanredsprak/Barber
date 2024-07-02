@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4> {{ __('labels.Contact Us') }}</h4>
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
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('contact-us.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
