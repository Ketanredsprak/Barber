@extends('Admin.layouts.app')
@section('content')

@php
   $locale = Illuminate\Support\Facades\App::getLocale();
    $name = "name_".$locale;
@endphp

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ __('labels.Subjects') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        @if (auth()->user()->can('subject-create'))
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createsubjectmodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display subject-data">
                                <thead>
                                    <tr>
                                        <th>{{ __('labels.ID') }}</th>

                                        <th>{{ __('labels.Subject Name') }}</th>

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



    <!-- create subject model --->
    <div class="modal fade" id="createsubjectmodel" tabindex="-1" role="dialog" aria-labelledby="createsubjectmodel"
        aria-hidden="true">
        @include('Admin.Subjects.create')
    </div>
    <!-- create subject model end --->


    <!-- edit subject model --->
     <div class="modal fade" id="editsubjectmodel" tabindex="-1" role="dialog" aria-labelledby="editsubjectmodel"
        aria-hidden="true">
    </div>
    <!-- edit subject model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.subject-data').DataTable({
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
                subject: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('subject.index') }}",
                order: [1],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'subject_name',
                        name: 'subject_name'
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
            $(".subject-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".subject-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add subject submit
              $("#subject-frm").submit(function(event) {
                  event.preventDefault();
                  var frm = this;
                  create_record(frm, table);
              });
            //add subject submit end


            //get subject data for edit page
              $(".subject-data").on('click', '.edit-data', function(e) {
                  $.ajax({
                      method: "GET",
                      url: $(this).data('url'),
                      success: function(response) {
                          $('#editsubjectmodel').html(response);
                          $('#editsubjectmodel').modal('show');
                      },
                      error: function(response) {
                          handleError(response);
                      },
                  });
              });
            //get subject data for edit page end


            //edit subject
             $(document).on('submit', '#subject-edit-form', function(e) {
                 e.preventDefault();
                 var frm = this;
                 var url = $(this).attr('action');
                 var formData = new FormData(frm);
                 formData.append("_method", 'PUT');
                 var model_name = "#editsubjectmodel";
                 edit_record(frm, url, formData, model_name, table);
            });


        });






        </script>

@endsection
