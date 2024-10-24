<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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

    th, td {
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

    .invoice-header, .invoice-body {
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
                <img src="assets/img/logo.png" width="141" height="auto" class="logo">
                <div class="address">
                  5th Floor, Darshanam Oxy Park,<br />
                  Vasna Bhayli Road,<br />
                  Vadodara, Gujarat, INDIA
                </div>
              </td>
              <td align="right" valign="top" width="50%" style="padding: 10px;">
                <strong>Bill To</strong> <br />
                <span class="title">Invoice Date:</span> 2023-11-10 <br>
                <span class="title">Due Date:</span> 2023-11-10 <br>
                <span class="title">Sale Agent:</span> Jarvis
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
          <span class="title">Customer Name:</span> Test
        </td>
      </tr>
    </table>

    <table>
      <thead class="table-header">
        <tr>
          <th>Booking ID</th>
          <th>Service ID</th>
          <th>Service Name</th>
          <th>Price</th>
          <th>Start Time</th>
          <th>End Time</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>01</td>
          <td>15</td>
          <td>dfdf</td>
          <td>dfdf</td>
          <td>dfdf</td>
          <td>dfdf</td>
        </tr>
        <tr>
          <td>01</td>
          <td>12</td>
          <td>dfdf</td>
          <td>dfdf</td>
          <td>dfdf</td>
          <td>dfdf</td>
        </tr>
      </tbody>
    </table>

    <table class="subtotal-table" align="right">
      <tr>
        <td style="width:80%">Sub Total:</td>
        <td style="text-align:left">10000</td>
      </tr>
      <tr>
        <td style="width:80%">Tax:</td>
        <td style="text-align:left">10000</td>
      </tr>
      <tr>
        <td style="width:80%">Total Amount:</td>
        <td style="text-align:left">10000</td>
      </tr>
    </table>
  </div>
</body>

</html>
