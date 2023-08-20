<html>
<head>
    <title>INVOICE-{{$reservation->reference_id}} - {{ $reservation->date->format('F j, Y - H:i') }}</title>
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
            <h2>UMAI SUSHI</h2>
        </div>
        <div class="invoice-info">
            <h2>{{$reservation->reference_id}}</h2>
            <h3>{{$reservation->name}}</h3>
            <p>{{ $reservation->date->format('H:i - F j, Y ') }}</p>
            <p>Nomor meja: {{$reservation->table_number}}</p>
            <p>Jumlah orang: {{$reservation->number_of_people}}</p>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->menu->custom_id}}</td>
                    <td>{{$order->menu->name}}</td>
                    <td>x{{$order->quantity}}</td>
                    <td>{{formatRupiah($order->menu->price)}}</td>
                    <td>{{ formatRupiah($order->menu->price * $order->quantity) }}</td>
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
                    <td>{{ formatRupiah($orders->sum(function ($order) {
                        return $order->menu->price * $order->quantity;
                    })) }}</td>
                    <td>{{ formatRupiah($enteredAmount) }}</td>
                    <td>{{ formatRupiah($change) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice-footer">
        <p>Thank you for dining at our restaurant!</p>
    </div>
</body>
</html>