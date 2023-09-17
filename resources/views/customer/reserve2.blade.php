<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.tailwindcss.com"></script>

        <title>Order Form</title>
    </head>
    <body class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/images/bg/bg.jpg') }}');">
        <div class="flex flex-col items-center">
            <img width="100" src="{{ asset('assets/images/logo/umaisushi.png') }}" alt="" class="mb-6">
            <div class="bg-white rounded-lg shadow-lg p-12 w-96">
                <h1 class="text-2xl font-semibold mb-6 text-center">Table {{$reservation->table_number}}</h1>
                <h1 class="text-xl font-semibold mb-6 text-center"> {{$reservation->reference_id}}</h1>
                <h1 class="text-xl font-semibold mb-6 text-center"> {{$reservation->name}}</h1>
                <h1 class="text-xl font-semibold mb-6 text-center">{{ $reservation->date->format('H:i - F j, Y ') }}</h1>
                <p class="text-center text-sm">Screenshot and show this to our staff</p>
            </div>
        </div>
        <script>
            function validateForm() {
                var name = document.getElementById("name").value;
                var numberOfPeople = document.getElementById("number_of_people").value;
                
                if (name.trim() === "" || numberOfPeople.trim() === "") {
                    alert("Nama dan Jumlah Orang harus diisi!");
                    return false;
                }
                
                return true;
            }
        </script>
    </body>
</html>