@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ __('labels.States') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createstatemodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                {{ __('labels.Add New') }}  </button></li>
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
                            <table class="display state-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>{{ __('labels.Country Name') }}</th>
                                        <th>{{ __('labels.Name') }}</th>
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



    <!-- create state model --->
    <div class="modal fade" id="createstatemodel" tabindex="-1" role="dialog" aria-labelledby="createstatemodel"
        aria-hidden="true">
        @include('Admin.States.create')
    </div>
    <!-- create state model end --->


    <!-- edit state model --->
     <div class="modal fade" id="editstatemodel" tabindex="-1" role="dialog" aria-labelledby="editstatemodel"
        aria-hidden="true">
    </div>
    <!-- edit state model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.state-data').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "sProcessing":    "{{ __('labels.Processing') }}...",
                    "sLengthMenu":    "{{ __('labels.Show') }} _MENU_ {{ __('labels.Entries') }}",
                    "sZeroRecords":   "{{ __('labels.No matching records found') }}",
                    "sEmptyTable":    "Ningún dato disponible en esta tabla",
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
                state: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('state.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'country_name',
                        name: 'country_name'
                    },
                    {
                        data: 'name',
                        name: 'name'
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
            $(".state-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".state-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add state submit
              $("#state-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add state submit end


            //get state data for edit page
              $(".state-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editstatemodel').html(response);
                          $('#editstatemodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get state data for edit page end


            //edit state
             $(document).on('submit', '#state-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editstatemodel";
                 edit_record(frm, url, formData, model_name, table);
            });

        });



    </script>
@endsection
