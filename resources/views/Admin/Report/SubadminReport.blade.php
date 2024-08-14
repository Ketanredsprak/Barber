@extends('Admin.layouts.app')
@section('content')

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Admin Report</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Include DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <style>
        .card-container {
            width: 90%;
            margin: 0 auto;
        }
    </style>
</head>

<body> --}}
    <div class="page-title">
        <div class="row">
            <div class="col-5">
                <h4>{{ __('labels.Sub Admin Report') }}  </h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-xxl-12 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">{{ __('labels.Start Date') }}</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">{{ __('labels.End Date') }} </label>
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">{{ __('labels.Gender') }}</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="">{{ __('labels.Select Gender') }} </option>
                                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>
                                            {{ __('labels.Male') }}
                                        </option>
                                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>
                                            {{ __('labels.Female') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary me-2">{{ __('labels.Apply') }}</button>
                            <button type="button" id="reset-button" class="btn btn-secondary">{{ __('labels.Reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- DataTable Card -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="subadmin-table" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('labels.No') }}</th>
                                    <th>{{ __('labels.Name') }}</th>
                                    <th>{{ __('labels.Email') }}</th>
                                    <th>{{ __('labels.Phone') }}</th>
                                    <th>{{ __('labels.Gender') }}</th>
                                    <th>{{ __('labels.Status') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('script')
      
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}">
        </script>
        <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
      
    <script>
        $(document).ready(function () {
            var table = $('#subadmin-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('subadmin.report.data') }}',
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.gender = $('#gender').val();
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Ajax error:', error, thrown);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'gender', name: 'gender' },
                    { data: 'status', name: 'status' }
                ],
                ordering: false,
                searching: false,
                dom: 'Brtip',
                paging:false,
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        title: 'subadmin_Report',
                        className: 'btn btn-success'
                    }
                ],
                "drawCallback": function () {
                    var api = this.api();
                    api.column(0).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });

            $('#reset-button').click(function () {
                window.location.href = '{{ route('subadmin.report') }}';
            });
        });
    </script>

{{-- </body>

</html> --}}

@endsection