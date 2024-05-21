@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Cities</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcitymodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display city-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>State Name</th>
                                        <th>English Name</th>
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



    <!-- create city model --->
    <div class="modal fade" id="createcitymodel" tabindex="-1" role="dialog" aria-labelledby="createcitymodel"
        aria-hidden="true">
        @include('Admin.Cities.create')
    </div>
    <!-- create city model end --->


    <!-- edit city model --->
     <div class="modal fade" id="editcitymodel" tabindex="-1" role="dialog" aria-labelledby="editcitymodel"
        aria-hidden="true">
    </div>
    <!-- edit city model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.city-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                city: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('city.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'state_name',
                        name: 'state_name'
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
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
            $(".city-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".city-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add city submit
              $("#city-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add city submit end


            //get city data for edit page
              $(".city-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editcitymodel').html(response);
                          $('#editcitymodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get city data for edit page end


            //edit city
             $(document).on('submit', '#city-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editcitymodel";
                 edit_record(frm, url, formData, model_name, table);
            });


            $('.country_id').on('change', function() {
                var country =this.value ;
                var state_id = $('#state_id').val();
                  //  alert(state_id);
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('state.list') }}",
                data: {
                    country: country
                },
                success: function(response) {
                    $('#states').removeClass('d-none');
                    $('#stateData').empty();
                    jQuery.each(response, function(index, item) {
                        $('#stateData').append(' <option value='+ item['id'] + ' >'+ item['name_en'] +'</option>  ')
                    });
                }
                });
            });


        });






        </script>

@endsection
