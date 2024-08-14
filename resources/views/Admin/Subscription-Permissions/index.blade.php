@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4> {{ __('labels.Subscription Permission') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createsubpermissionmodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                {{ __('labels.Add New') }} </button></li>
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
                            <table class="display subpermission-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>{{ __('labels.Permission Name') }}</th>
                                        <th>{{ __('labels.Permission For User') }}</th>
                                        <th>{{ __('labels.Permission Input Box') }}</th>
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



    <!-- create subscription permissions model --->
    <div class="modal fade" id="createsubpermissionmodel" tabindex="-1" role="dialog" aria-labelledby="createsubpermissionmodel"
        aria-hidden="true">
        @include('Admin.Subscription-Permissions.create')
    </div>
    <!-- create subscription permissions model end --->


    <!-- edit subpermission model --->
     <div class="modal fade" id="editsubpermissionmodel" tabindex="-1" role="dialog" aria-labelledby="editsubpermissionmodel"
        aria-hidden="true">
    </div>
    <!-- edit subpermission model end --->

    <script src="{{ static_asset('admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/theme-customizer/customizer.js') }}"></script>

@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.subpermission-data').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "sProcessing":    "{{ __('labels.Processing') }}...",
                    "sLengthMenu":    "{{ __('labels.Show') }} _MENU_ {{ __('labels.Entries') }}",
                    "sZeroRecords":   "{{ __('labels.No matching records found') }}",
                    "sEmptyTable":    "{{ __('labels.No records found') }}",
                    "sInfo":          "{{ __('labels.Showing') }} _START_ {{ __('labels.To') }} _END_ {{ __('labels.Of')}} _TOTAL_ {{ __('labels.Entries') }}",
                    "sInfoEmpty":     "{{ __('labels.Showing') }} 0 {{ __('labels.To') }} 0 {{ __('labels.Of')}} 0 {{ __('labels.Entries') }}",
                    "sInfoFiltered":  "({{ __('labels.Filtered')}} {{ __('labels.Of')}} _MAX_ {{ __('labels.Entries') }})",
                    "sInfoPostFix":   "",
                    "sSearch":        "{{ __('labels.Search') }}",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "{{ __('labels.Processing') }}...",
                    "oPaginate": {
                        "sFirst":    "{{ __('labels.First') }}",
                        "sLast":    "{{ __('labels.Last') }}",
                        "sNext":    "{{ __('labels.Next') }}",
                        "sPrevious": "{{ __('labels.Previous') }}"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('subscription-permission.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'permission_name',
                        name: 'permission_name'
                    },
                    {
                        data: 'permission_for_user',
                        name: 'permission_for_user'
                    },
                    {
                        data: 'is_input_box',
                        name: 'is_input_box'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            //add service submit
                $("#subpermission-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add service submit end


            //delete record
            $(".subpermission-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".subpermission-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });




            //get subpermission data for edit page
              $(".subpermission-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editsubpermissionmodel').html(response);
                          $('#editsubpermissionmodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get subpermission data for edit page end


            //edit subpermission
             $(document).on('submit', '#subpermission-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editsubpermissionmodel";
                 edit_record(frm, url, formData, model_name, table);
            });



            $('#permission_for_user').on('change', function() {
            var permission_for_user = $('#permission_for_user').val();
            // var subscription_name = "subscription_name_";

            var str1 = "subscription_name_";
            var str2 = "{{ $locale = config('app.locale') }}";
            var subscription_name = str1.concat(str2);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('get.subscription.list') }}",
                data: {
                    permission_for_user: permission_for_user
                },
                success: function(response) {
                    $('.SubscriptionData').empty();
                    jQuery.each(response, function(index, item) {
                        $('.SubscriptionData').append(' <option value=' + item['id'] +
                            ' >' + item[subscription_name] + '</option>  ')
                    });
                }
            });
        });



        $('#is_input_box').change(function() {
            if ($(this).is(':checked')) {
                $('#additional-input').removeClass('d-none');
            } else {
                $('#additional-input').addClass('d-none');
            }
        });


        });



    </script>
@endsection
