@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ __('labels.Barbers') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createbarbermodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                {{ __('labels.Add New') }}</button></li>
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
                            <table class="display barber-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>
                                        <th>{{ __('labels.Barber Detail') }}</th>
                                        <th>{{ __('labels.Phone') }}</th>
                                        <th>{{ __('labels.Joing Date') }}</th>
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



    <!-- create barber model --->
    <div class="modal fade" id="createbarbermodel" tabindex="-1" role="dialog" aria-labelledby="createbarbermodel"
        aria-hidden="true">
        @include('Admin.Barbers.create')
    </div>
    <!-- create barber model end --->


    <!-- edit barber model --->
     <div class="modal fade" id="editbarbermodel" tabindex="-1" role="dialog" aria-labelledby="editbarbermodel"
        aria-hidden="true">
    </div>
    <!-- edit barber model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.barber-data').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    "sProcessing":    "{{ __('labels.Processing') }}...",
                    "sLengthMenu":    "{{ __('labels.Show') }} _MENU_ {{ __('labels.Entries') }}",
                    "sZeroRecords":   "{{ __('labels.No matching records found') }}",
                    "sEmptyTable":    "Ningún dato disponible en esta tabla",
                    "sInfo":          "{{ __('labels.Showing') }} _START_ {{ __('labels.To') }} _END_ {{ __('labels.Of')}} _TOTAL_ {{ __('labels.Entries') }}",
                    "sInfoEmpty":     "{{ __('labels.Showing') }} 0 {{ __('labels.To') }} 0 {{ __('labels.Of')}} 0 {{ __('labels.Entries') }}",
                    "sInfoFiltered":  "(filtrado {{ __('labels.Of')}} _MAX_ {{ __('labels.Entries') }})",
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
                barber: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('barber.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_details',
                        name: 'user_details'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'joing_date',
                        name: 'joing_date'
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
            $(".barber-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".barber-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add barber submit
              $("#barber-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add barber submit end


            //get barber data for edit page
              $(".barber-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editbarbermodel').html(response);
                          $('#editbarbermodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get barber data for edit page end


            //edit barber
             $(document).on('submit', '#barber-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editbarbermodel";
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
