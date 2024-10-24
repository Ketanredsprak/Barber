<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$config = getWebsiteConfig();
$language = config('app.locale');
$location = 'location_' . $language;

?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <style type="text/css">
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
            font-size: 14px;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #1C2749;
            color: #ffffff;
            font-weight: bold;
        }

        .table-header th {
            padding: 10px;
            font-size: 14px;
        }

        .subtotal-table {
            margin-top: 20px;
            font-size: 14px;
            width: 100%;
            border: none;
        }

        .subtotal-table td {
            padding: 5px 10px;
            text-align: right;
        }

        .invoice-details td {
            padding: 10px;
            line-height: 24px;
            color: #222222;
        }

        .invoice-details .title {
            font-weight: bold;
        }

        .invoice-header,
        .invoice-body {
            margin: 0;
            padding: 0;
        }

        .logo {
            margin-bottom: 20px;
        }

        .address {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <table>
            <tr>
                <td align="left" valign="top" style="padding: 20px;">
                    <table>
                        <tr>
                            <td align="left" valign="top" width="50%">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/images/logo/logo.png'))) }}" width="141" height="auto" class="logo">
                                <div class="address">
                                    {{ $config->location_en }}
                                </div>
                            </td>
                            <td align="right" valign="top" width="50%" style="padding: 10px;">
                                <strong>Bill To</strong> <br />
                                <span class="title">Salon Name:</span> {{ $bdata->barber_detail->salon_name }} <br>
                                <span class="title">Location :</span> {{ $bdata->barber_detail->location }} <br>
                                <span class="title">Booking Date:</span> {{ $bdata->booking_date }} <br>
                                <span class="title">Booking Time:</span> {{ $bdata->start_time }} -
                                {{ $bdata->end_time }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-body">
        <table class="invoice-details">
            <tr>
                <td width="50%">
                    <span class="title">Customer Name:</span> {{ @$bdata->customer_detail->first_name }}
                    {{ @$bdata->customer_detail->last_name }},<br>
                    <span class="title">Email:</span> {{ @$bdata->customer_detail->email }},<br>
                    <span class="title">Phone :</span> {{ @$bdata->customer_detail->phone }}<br>
                </td>
            </tr>
        </table>

        <table>
            <thead class="table-header">
                <tr>
                    <th>Service ID</th>
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($bdata->booking_service_detailss as $services)
                    <tr>
                        <td> {{ $services->service_id }}</td>
                        <td> {{ $services->service_name_en }}</td>
                        <td> {{ $services->price }}</td>
                        <td>{{ $services->start_time }}</td>
                        <td>{{ $services->end_time }}</td>
                    </tr>
                @endforeach



            </tbody>
        </table>

        <table class="subtotal-table" align="right">
            <tr>
                <td style="width:80%">Total :</td>
                <td style="text-align:left">{{ $bdata->total_price }}.00</td>
            </tr>
        </table>
    </div>
</body>

</html>
