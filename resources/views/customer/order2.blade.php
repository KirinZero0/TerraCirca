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
            <img width="200" src="{{ asset('assets/images/logo/umaisushi.png') }}" alt="" class="mb-6 mt-6">
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
            </div>
            <div class="container mx-auto mt-5 px-4">
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($menus->where('type', \App\Models\Menu::MAKANAN) as $menu)
                        <div class="bg-white p-4 rounded-lg shadow-md mb-3 border-b-4 border-[#4693B1]">
                            <img src="{{  $menu->getImageUrl() }}" alt="Item 1" class="mb-4 w-full h-32 object-cover rounded-t-lg">
                            <div class="p-2">
                                <h3 class="text-xl font-semibold mb-2">{{$menu->name}}</h3>
                                <p class="text-gray-600 text-sm">{{$menu->description}}</p>
                                <p class="text-gray-600 text-sm">{{ formatRupiah($menu->price) }}</p>
                            </div>
                            <form action="{{ route('customer.add.order')}}" enctype="multipart/form-data" method="post"
                            class="relative" novalidate onkeydown="return event.key !== 'Enter';">
                            @csrf
                                <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
                                <input type="hidden" name="menu_id" value="{{$menu->id}}">
                                <input type="number" name="quantity" class="w-16 text-center border rounded-md mr-2" value="1"  min="1">
                                <button type="submit" class="bg-[#4693B1] text-white p-1 w-[3rem] h-[3rem] rounded-full hover:bg-blue-600 absolute bottom-[-1.5rem] right-[-1.5rem]">
                                    <i class="fa-regular fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-600 mt-4">Tidak Ada Makanan Yang Tersedia</p>
                    @endforelse
                
                    @forelse($menus->where('type', \App\Models\Menu::MINUMAN) as $menu)
                        <div class="bg-white p-4 rounded-lg shadow-md mb-3 border-b-4 border-[#4693B1]">
                            <img src="{{  $menu->getImageUrl() }}" alt="Item 1" class="mb-4 w-full h-32 object-cover rounded-t-lg">
                            <div class="p-2">
                                <h3 class="text-xl font-semibold mb-2">{{$menu->name}}</h3>
                                <p class="text-gray-600 text-sm">{{$menu->description}}</p>
                                <p class="text-gray-600 text-sm">{{ formatRupiah($menu->price) }}</p>
                            </div>
                            <form action="{{ route('customer.add.order')}}" enctype="multipart/form-data" method="post"
                            class="relative" novalidate onkeydown="return event.key !== 'Enter';">
                            @csrf
                                <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
                                <input type="hidden" name="menu_id" value="{{$menu->id}}">
                                <input type="number" name="quantity" class="w-16 text-center border rounded-md mr-2" value="1"  min="1">
                                <div>
                                    <button type="submit" class="bg-[#4693B1] text-white p-1 w-[3rem] h-[3rem] rounded-full hover:bg-blue-600 absolute bottom-[-1.5rem] right-[-1.5rem]">
                                        <i class="fa-regular fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-600 mt-4">Tidak Ada Minuman Yang Tersedia</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-2" style="height: 5rem;"></div> <!-- Empty div with 1rem height -->
        <button id="openModal" class="fixed bottom-4 right-4 bg-[#4693B1] text-white py-3 px-6 rounded-full shadow-lg hover:bg-blue-600">
            Your Order
            <span class="bg-red-500 text-white rounded-full h-6 w-6 flex items-center justify-center absolute -top-1 -right-1">{{$totalQuantity}}</span>
        </button>
        <div id="modalOverlay" class="fixed inset-0 bg-black opacity-60 z-40 hidden"></div>

        <div id="myModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="container mx-auto">
                <div class="bg-neutral-100 shadow-md p-8 mt-3  rounded-lg relative max-w-sm mx-auto">
                    <button id="closeModal" class="absolute top-2 right-2 py-1 px-2 w-10 h-10 rounded-full text-white bg-[#4693B1]">
                        <i class="fa-solid fa-x"></i>
                    </button>
                    <h1 class="text-center text-xl font-semibold mb-6">Your Order</h1>
                    <div class="mb-4 mx-auto">
                        @forelse ($orders as $order)
                        <div class="grid grid-cols-4 gap-4">
                            <div><strong>{{$order->menu->name}}</strong></div>
                            <div class="text-right">{{formatRupiah($order->menu->price)}}</div>
                            <div class="text-right">x{{$order->quantity}}</div>
                            <div class="text-right"> <!-- Use 'justify-end' class to align the Delete button to the right -->
                                <a href="{{ route('customer.delet.order', $order->id)}}" class="bg-red-500 text-white py-1 px-2 rounded-md text-sm hover:bg-red-600">
                                    <i class="fa-sharp fa-solid fa-trash"></i>
                                </a>
                            </div>
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
                    <div class="mt-2" style="height: 1rem;"></div> <!-- Empty div with 1rem height -->
                    <a href="{{route('customer.finish', $reservation->reference_id)}}" class="block bg-[#4693B1] text-white py-2 px-4 rounded-lg hover:bg-blue-600 w-full text-center">
                        Submit Order
                    </a>
                </div>
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
