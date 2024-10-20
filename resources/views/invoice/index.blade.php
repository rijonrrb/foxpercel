<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 100%;
            width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
            margin-bottom: 20px;
        }
        .footer {
          text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header small {
            font-size: 14px;
            color: gray;
        }
        .logo {
            float: left;
        }
        .logo {
            width: 70px;
            height: 70px;
            border-radius: 10px;
        }
        .details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .panel {
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
        }
        h3 {
          font-size: 18px;
          margin-bottom: 20px;
          padding-bottom: 10px;
          border-bottom: 1px dotted #c5c5c5;
        }
        dl {
            margin: 0;
        }
        dt {
            float: left;
            clear: both;
            font-weight: bold;
            width: 100px;
        }
        dd {
            margin-left: 110px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
        }
        td:first-child {
            text-align: left;
        }
        .text-muted {
            font-size: 12px;
            color: gray;
        }
        .text-right {
            text-align: right;
        }
        .mono {
            font-family: monospace;
        }
        .rowtotal th {
            background-color: #f9f9f9;
            font-size: 16px;
        }
        .comments, .payment-method {
            margin-top: 20px;
        }
        .payment-method ul {
            padding-left: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: gray;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .details {
                display: block;
            }
            .panel {
                width: 100% !important;
                margin-bottom: 20px;
            }
            .container {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 18px;
            }
            .header small {
                font-size: 12px;
            }
            table, th, td {
                font-size: 12px;
            }
            .payment-method ul {
                padding-left: 15px;
            }
            .container {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
          <div>
            <img class="media-object logo" src="https://dummyimage.com/70x70/000/fff&amp;text=ACME">
          </div>
          <div style="text-align: end;">
            <h1>Invoice</h1>
            <h4>NO: order_number | Date: 01/01/2015</h4>
          </div>
        </div>

        <div class="details">
            <div class="panel" style="width: 48%;">
                <h3>Company Details</h3>
                <dl>
                    <dt>Name</dt>
                    <dd>Site Name</dd>
                    <dt>Address</dt>
                    <dd>Field 3, Moon</dd>
                    <dt>Phone</dt>
                    <dd>123.4456.4567</dd>
                    <dt>Email</dt>
                    <dd>mainl@acme.com</dd>
                </dl>
            </div>

            <div class="panel" style="width: 48%;">
                <h3>Customer Details</h3>
                <dl>
                    <dt>Name</dt>
                    <dd>user_name</dd>
                    <dt>Delivery Address</dt>
                    <dd>One Microsoft Way, Redmond, WA 98052-7329, USA</dd>
                    <dt>Phone</dt>
                    <dd>(425) 882-8080</dd>
                    <dt>Email</dt>
                    <dd>contact@microsoft.com</dd>
                </dl>
            </div>
        </div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Item / Details</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Gross Weight</th>
                        <th>Dimension Weigh</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item Name<br><small class="text-muted">Color: Item Color</small></td>
                        <td>1</td>
                        <td>$18.00</td>
                        <td>3.00 lbs</td>
                        <td>5.00 lbs</td>
                        <td>total Quantity x price</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="items" style="margin-top: 20px;">
            <table>
                <tr>
                    <th>Sub Total</th>
                    <th>Discount</th>
                    <th>Final</th>
                </tr>
                <tr>
                    <td>$18,240.00</td>
                    <td>-$1,800.00</td>
                    <td>$19,752.00</td>
                </tr>
            </table>
        </div>

        <div class="comments panel">
            <h3>Comments / Notes</h3>
            <p>notes</p>
        </div>

        <div class="payment-method panel">
            <h3>Payment Method</h3>
            <p>Not selected yet</p>
        </div>

        <div class="footer">
            <p>Thank you for choosing our services.<br>We hope to see you again soon.<br><strong>Company_name</strong></p>
        </div>
    </div>
</body>
</html>
