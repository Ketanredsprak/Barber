@extends('Admin.layouts.app')

@section('content')

    <div class="page-title">
        <div class="row">
            <div class="col-5">
                <h4> {{ __('labels.Booking Report') }} </h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-xxl-12 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <form id="filter-form" method="GET"> --}}
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label"> {{ __('labels.Start Date') }} </label>
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label"> {{ __('labels.End Date') }} </label>
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="customer_search_detail" class="form-label">
                                        {{ __('labels.Customer') }} </label>
                                    <input type="text" id="customer_search_detail" name="customer_search_detail"
                                        class="form-control" placeholder="  {{ __('labels.Name, Email, Phone Number') }}  "
                                        value="{{ old('customer_search_detail', request('customer_search_detail')) }}" />
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="barber_search_detail" class="form-label">
                                        {{ __('labels.Barber') }} </label>
                                    <input type="text" id="barber_search_detail" name="barber_search_detail"
                                        class="form-control" placeholder=" {{ __('labels.Name, Email, Phone Number') }} "
                                        value="{{ old('barber_search_detail', request('barber_search_detail')) }}" />
                                </div>
                            </div>




                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="status" class="form-label"> {{ __('labels.Status') }} </label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">{{ __('labels.Select Status') }}</option>
                                        <option value="pending"
                                            {{ old('status', request('status')) == 'pending' ? 'selected' : '' }}>
                                            {{ __('labels.Pending') }}
                                        </option>
                                        <option value="reject"
                                            {{ old('status', request('status')) == 'reject' ? 'selected' : '' }}>
                                            {{ __('labels.Reject') }}
                                        </option>
                                        <option value="accept"
                                            {{ old('status', request('status')) == 'accept' ? 'selected' : '' }}>
                                            {{ __('labels.Accept') }}
                                        </option>
                                        <option value="finished"
                                            {{ old('status', request('status')) == 'finished' ? 'selected' : '' }}>
                                            {{ __('labels.Finished') }}
                                        </option>
                                        <option value="rescheduled"
                                            {{ old('status', request('status')) == 'rescheduled' ? 'selected' : '' }}>
                                            {{ __('labels.Rescheduled') }}
                                        </option>
                                        <option value="cancel"
                                            {{ old('status', request('status')) == 'cancel' ? 'selected' : '' }}>
                                            {{ __('labels.Cancel') }}
                                        </option>
                                    </select>

                                </div>
                            </div>



                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" id="apply-button" class="btn btn-primary me-2">{{ __('labels.Apply') }}</button>
                            <button type="button" id="reset-button"
                                class="btn btn-secondary">{{ __('labels.Reset') }}</button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>

        <!-- DataTable Card -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">


                        <table id="export-button" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('labels.No') }}</th>
                                    <th>{{ __('labels.Customer Detail') }}</th>
                                    <th>{{ __('labels.Barber Detail') }}</th>
                                    <th>{{ __('labels.Booking Date') }}</th>
                                    <th>{{ __('labels.Start Time') }}</th>
                                    <th>{{ __('labels.End Time') }}</th>
                                    <th>{{ __('labels.Total Price') }}</th>
                                    <th>{{ __('labels.Status') }}</th>
                                </tr>
                            </thead>
                            <!-- No <tfoot> here unless needed -->
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
        $(document).ready(function() {
            // Initialize DataTable only if it hasn't been initialized yet
            if (!$.fn.DataTable.isDataTable('#export-button')) {
                var table = $('#export-button').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('booking.report.data') }}',
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            d.barber_search_detail = $('#barber_search_detail').val();
                            d.customer_search_detail = $('#customer_search_detail').val();
                            d.status = $('#status').val();
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            },
                            // title: 'No'
                        },
                        {
                            data: 'customer_detail',
                            name: 'customer_detail'
                        },
                        {
                            data: 'barber_detail',
                            name: 'barber_detail'
                        },
                        {
                            data: 'booking_date',
                            name: 'booking_date'
                        },
                        {
                            data: 'start_time',
                            name: 'start_time'
                        },
                        {
                            data: 'end_time',
                            name: 'end_time'
                        },
                        {
                            data: 'total_price',
                            name: 'total_price'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        }
                    ],
                    ordering: false,
                    searching: false,
                    paging: false,
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'csvHtml5',
                        text: 'Export CSV',
                        titleAttr: 'Export as CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }]
                });

                // Reset button functionality
                $('#reset-button').click(function() {
                    
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#barber_search_detail').val('');
                    $('#customer_search_detail').val('');
                    $('#status').val('');
                    table.draw();
                });
                $('#apply-button').click(function() {
                    table.draw();
                });
            }
        });
    </script>


  
@endsection
