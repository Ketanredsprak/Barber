@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Roles</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createrolemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display role-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
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



    <!-- create role model --->
    <div class="modal fade" id="createrolemodel" tabindex="-1" role="dialog" aria-labelledby="createrolemodel"
        aria-hidden="true">
        @include('Admin.Roles.create')
    </div>
    <!-- create role model end --->


    <!-- edit role model --->
     <div class="modal fade" id="editrolemodel" tabindex="-1" role="dialog" aria-labelledby="editrolemodel"
        aria-hidden="true">
    </div>
    <!-- edit role model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.role-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                role: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('role.index') }}",
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
            $(".role-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //add role submit
              $("#role-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add role submit end


            //get role data for edit page
              $(".role-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editrolemodel').html(response);
                          $('#editrolemodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get role data for edit page end


            //edit role
             $(document).on('submit', '#role-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editrolemodel";
                 edit_record(frm, url, formData, model_name, table);
            });

        });


        $("#selectall").click(function(e) {
               $(".checkBoxClass").prop('checked', this.checked);
        });


    </script>






@endsection
