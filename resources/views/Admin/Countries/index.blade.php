@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Countries</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcountrymodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display country-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Short Code</th>
                                        <th>English Name</th>
                                        <th>Phone Code</th>
                                        <th>Status</th>
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



    <!-- create country model --->
    <div class="modal fade" id="createcountrymodel" tabindex="-1" role="dialog" aria-labelledby="createcountrymodel"
        aria-hidden="true">
        @include('Admin.Countries.create')
    </div>
    <!-- create country model end --->


    <!-- edit country model --->
     <div class="modal fade" id="editcountrymodel" tabindex="-1" role="dialog" aria-labelledby="editcountrymodel"
        aria-hidden="true">
    </div>
    <!-- edit country model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.country-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                country: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('country.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'shortname',
                        name: 'shortname'
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
                    },
                    {
                        data: 'phonecode',
                        name: 'phonecode'
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
            $(".country-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".country-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add country submit
              $("#country-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add country submit end


            //get country data for edit page
              $(".country-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editcountrymodel').html(response);
                          $('#editcountrymodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get country data for edit page end


            //edit country
             $(document).on('submit', '#country-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editcountrymodel";
                 edit_record(frm, url, formData, model_name, table);
            });

        });



    </script>
@endsection
