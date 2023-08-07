<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://kit.fontawesome.com/08332481a6.js" crossorigin="anonymous"></script>

        <title>Order Form</title>
    </head>
    <body class="bg-[#BBD2E4] flex flex-col items-center justify-center min-h-screen">
            <img width="100" src="{{ asset('assets/images/logo/umaisushi.png') }}" alt="" class="mb-6 mt-2">
            <div class="container mx-auto">
                <div class="bg-white shadow-md p-6 mt-3 rounded-lg relative w-full max-w-sm md:w-full lg:w-full mx-auto border-b-4 border-[#4693B1]">
                    <div class="mb-4 flex justify-between items-start">
                        <span class="inline-block bg-[#4693B1] text-white font-bold py-1 px-3 rounded-lg text-lg">
                            {{$reservation->reference_id}}
                        </span>
                        <span class="inline-block bg-[#4693B1] text-white font-bold py-1 px-3 rounded-lg text-lg">
                            {{$reservation->table_number}}
                        </span>
                    </div>
                    <div class="mb-4">
                        {{ $reservation->date->format('H:i - F j, Y ') }}
                    </div>
                    <div class="mb-4">
                        <strong>Nama:</strong> {{$reservation->name}}
                    </div>
                    <div class="mb-4">
                        <strong>Jumlah Orang:</strong> {{$reservation->number_of_people}}
                    </div>
                </div>
                <div class="bg-white shadow-md p-8 mt-3 rounded-lg relative max-w-sm mx-auto border-b-4 border-[#4693B1]">
                    <h1 class="text-center text-xl font-semibold mb-6">Your Order</h1>
                    <div class="mb-4 mx-auto">
                        @forelse ($orders as $order)
                        <div class="grid grid-cols-3 gap-4">
                            <div><strong>{{$order->menu->name}}</strong></div>
                            <div class="text-right">{{formatRupiah($order->menu->price)}}</div>
                            <div class="text-right">x{{$order->quantity}}</div>
                        </div>
                        @empty
                        <p class="text-center text-gray-600 mt-4">Order Kosong</p>
                        @endforelse
                    </div>
                        <div>
                            <strong>Total: </strong>{{ formatRupiah($orders->sum(function ($order) {
                                return $order->menu->price * $order->quantity;
                            })) }}
                        </div>
                </div>
                <div class="text-center max-w-sm mx-auto mt-3">
                    <h1 class="text-sm font-semibold">
                        Kami mengucapkan terima kasih atas pesanan Anda di restoran kami. 
                        Mohon bersabar sejenak sementara kami menyiapkan hidangan yang anda pesan. 
                    </h1>
                    <h1 class="text-sm font-semibold mt-3">
                        Jika ada kesalahan pemesanan, silakan laporkan ke kasir.
                    </h1>
                </div>
            </div>
           

    
        <script>
            const openModalButton = document.getElementById('openModal');
            const closeModalButton = document.getElementById('closeModal');
            const modal = document.getElementById('myModal');
            const modalOverlay = document.getElementById('modalOverlay');
    
            openModalButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modalOverlay.classList.remove('hidden')
                openModalButton.classList.add('hidden');
            });
    
            closeModalButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modalOverlay.classList.add('hidden')
                openModalButton.classList.remove('hidden');
            });
        </script>
    </body>
</html>
