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
            text-align: left;
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        .invoice-total {
        padding-top: 100px; /* Adjust the value as needed */
        }


        .invoice-total ul {
            list-style: none; /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        .invoice-total ul li {
            margin-bottom: 10px; /* Add spacing between list items */
            font-size: 16px; /* Adjust font size as needed */
        }

        .invoice-total ul li strong {
            display: inline-block;
            width: 100px; /* Adjust width for the label */
            font-weight: bold;
        }
        .invoice-footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px; /* Adjust the height of the footer here */
            line-height: 50px; /* Adjust the line height of the footer here */
        }
        .invoice-footer p {
        margin: 0;
        font-style: italic; /* Adds a warm, friendly tone */
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
            <ul>
                <li>
                    <strong>Subtotal:</strong> {{ formatRupiah($transaction->total_amount) }}
                </li>
                <li>
                    <strong>Diterima:</strong> {{ formatRupiah($transaction->paid_amount) }}
                </li>
                <li>
                    <strong>Kembalian:</strong> {{ formatRupiah($transaction->change_amount) }}
                </li>
            </ul>
        </div>
    </div>
    <div class="invoice-footer">
        <p>Terima kasih atas kunjungan Anda! Semoga lekas sembuh dan sehat selalu.</p>
    </div>
</body>
</html>