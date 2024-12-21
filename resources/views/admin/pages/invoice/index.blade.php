<html>
<head>
    <title>INVOICE-{{$transaction->reference_id}} - {{ $transaction->date->format('F j, Y - H:i') }}</title>
    <style>
        /* Add your invoice styling here */
        body {
            font-family: Arial, sans-serif;
            font-size: 17px;
            position: relative;
            min-height: 100vh;
        }
        .invoice {
            width: 100%;
            margin: 0 auto;
            padding-bottom: 50px; /* Adjust the height of the footer here */
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 10px;
            background-color: rgb(84, 84, 84);
            color: white;
        }
        .invoice-info {
            text-align: left;
            margin-bottom: 10px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th,
        .invoice-table td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .invoice-total {
            text-align: center;
            margin-top: 50px;
        }
        .invoice-total table {
        width: 100%;
        }

        .invoice-total table th,
        .invoice-total table td {
            width: 33.33%; /* Divide the width evenly for 3 columns */
            text-align: center; /* Center-align the content */
        }
        .invoice-footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px; /* Adjust the height of the footer here */
            line-height: 50px; /* Adjust the line height of the footer here */
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h2>TERRA CIRCA</h2>
        </div>
        <div class="invoice-info">
            <h2>{{$transaction->reference_id}}</h2>
            @if($transaction->patient)
            <p>{{ $transaction->patient->name. ' - ' . $transaction->patient->phone }}</p>
            @endif
            <p>{{ $transaction->date->format('F j, Y ') }}</p>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{$item->productStock->name}}</td>
                    <td>{{formatRupiah($item->productStock->selling_price)}}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{formatRupiah($item->total_amount)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="invoice-total">
            <table>
                <tr>
                    <th>Subtotal</th>
                    <th>Diterima</th>
                    <th>Kembalian</th>
                </tr>
                <tr>
                    <td>{{ formatRupiah($transaction->total_amount) }}</td>
                    <td>{{ formatRupiah($transaction->paid_amount) }}</td>
                    <td>{{ formatRupiah($transaction->change_amount) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice-footer">
        <p>Thank you for your visit!</p>
    </div>
</body>
</html>