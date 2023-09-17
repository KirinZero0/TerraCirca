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
            margin-top: 10px;
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
    </div>
    <div class="invoice-footer">
        <p>Show this to our staff and we will lead you to your table</p>
        {{-- <img width="40" src="{{ asset('assets/images/logo/UMAI.png') }}" alt=""> --}}
    </div>
</body>
</html>