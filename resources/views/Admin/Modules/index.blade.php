@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Modules</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createmodulemodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New </button></li>
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
                            <table class="display module-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>Name</th>
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



    <!-- create module model --->
    <div class="modal fade" id="createmodulemodel" tabindex="-1" role="dialog" aria-labelledby="createmodulemodel"
        aria-hidden="true">
        @include('Admin.Modules.create')
    </div>
    <!-- create module model end --->


    <!-- edit module model --->
     <div class="modal fade" id="editmodulemodel" tabindex="-1" role="dialog" aria-labelledby="editmodulemodel"
        aria-hidden="true">
    </div>
    <!-- edit module model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.module-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                module: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('module.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
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
            $(".module-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".module-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add module submit
              $("#module-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add module submit end


            //get module data for edit page
              $(".module-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editmodulemodel').html(response);
                          $('#editmodulemodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get module data for edit page end


            //edit module
             $(document).on('submit', '#module-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editmodulemodel";
                 edit_record(frm, url, formData, model_name, table);
            });

        });



    </script>
@endsection
