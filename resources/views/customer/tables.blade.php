<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://kit.fontawesome.com/08332481a6.js" crossorigin="anonymous"></script>

        <title>Order Form</title>
    </head>
    <body class="bg-[#BBD2E4] flex flex-col items-center  min-h-screen">
            <img width="200" src="{{ asset('assets/images/logo/umaisushi.png') }}" alt="" class="mb-6 mt-6">
            <div class="container mx-auto mt-5 px-4">
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($tables as $table)
                    <div class="bg-white p-4 rounded-lg shadow-md mb-5 border-b-4 border-[#4693B1]">
                        <div class="p-2 mb-4">
                            <h3 class="text-xl font-semibold mb-2">Table {{$table->table_number}} <i class="fas fa-utensils"></i></h3>
                            <p class="text-gray-600 text-sm">
                                @if($table->status === App\Models\Table::AVAILABLE)
                                <span class="w-full bg-[#00799e] rounded-md text-white py-1 px-1">{{$table->status}}</span>
                                @else
                                <span class="w-full bg-[#787878] rounded-md text-white py-1 px-1">{{$table->status}}</span>
                                @endif
                            </p>
                        </div>
                        @if($table->status === App\Models\Table::AVAILABLE)
                        <a class="w-full bg-[#4693B1] rounded-md text-white py-3 px-14 hover:bg-[#596978]" href="{{ route('customer.reserve', $table->reference_id) }}">Book</a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-2" style="height: 5rem;"></div> <!-- Empty div with 1rem height -->
    
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
