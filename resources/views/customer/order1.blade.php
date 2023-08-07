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
                <h1 class="text-2xl font-semibold mb-6 text-center">Table {{$table->table_number}}</h1>
                <form action="{{ route('customer.store') }}" enctype="multipart/form-data" method="post" novalidate onkeydown="return event.key !== 'Enter';">
                    @csrf
                    <input required type="text" id="table_number" name="table_number" value="{{$table->table_number}}" class="hidden mt-1 p-3 border w-full">
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input required type="text" id="name" name="name" class="mt-1 p-3 border w-full">
                    </div>
                    <div class="mb-6">
                        <label for="number_of_people" class="block text-sm font-medium text-gray-700">Jumlah Orang</label>
                        <input required type="number" id="number_of_people" name="number_of_people" class="mt-1 p-3 border w-full">
                    </div>
                    <button type="submit" class="w-full bg-[#4693B1] rounded-md text-white py-3 hover:bg-[#596978]" onclick="return validateForm()">Order</button>
                </form>
                
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