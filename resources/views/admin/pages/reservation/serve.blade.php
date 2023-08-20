@extends('layouts.admin')

@section('title', 'Serve')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.reservation.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Serve
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Reservasi</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$reservation->name}} <span class="badge badge-secondary">{{$reservation->reference_id}}</span></h5>
                            <p class="card-text">{{$reservation->date->format('F j, Y')}}</p>
                            <p class="card-text">Nomor Meja: {{$reservation->table_number}}</p>
                            <p class="card-text">Jumlah Orang: {{$reservation->number_of_people}}</p>
                            <h5 class="card-title">Order:</h5>
                            @forelse($orders as $order)
                            <p class="card-text d-flex align-items-center justify-content-between">{{$order->menu->name}}
                                <span class="ml-2 mr-2"> x{{$order->quantity}}</span> 
                                <span class="mr-2">{{ formatRupiah($order->menu->price * $order->quantity) }}</span> 
                                <a class="btn btn-sm btn-danger ml-auto" href="{{ route('admin.order.destroy', $order->id)}}"><i class="fas fa-trash"></i></a>
                            </p>     
                            @empty
                            <p class="card-text">Order Kosong</p>
                            @endforelse
                                <h5 class="card-title">Subtotal: 
                                    <strong>
                                    {{ formatRupiah($reservation->orders->sum(function($order) {
                                        return $order->menu->price * $order->quantity;
                                    })) }}
                                    </strong>  
                                </h5>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input id="moneyInput" type="text" class="form-control" placeholder="Input Amount" aria-label="Input Amount" aria-describedby="basic-addon1">
                                </div>
                                <h5 class="card-title" id="change"> Kembalian: </h5>
                            <a id="printInvoiceBtn" class="btn btn-success" href="{{route('admin.cashier.invoice2', $reservation->id)}}">Print Invoice</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Menu</h4>
                            <div>
                                <form>
                                    <div class="input-group">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian"
                                            value="{{ Request::input('search') ?? ''}}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                            
                        <div class="card-body">
                            <div class="table-responsive">
                                <h5 class="mb-3">Makanan</h5>
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        @forelse($menus->where('type', \App\Models\Menu::MAKANAN) as $menu)
                                            <tr>
                                                <form action="{{ route('admin.order.store')}}" enctype="multipart/form-data" method="post"
                                                class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                                                @csrf
                                                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                    <td style="width: 20%">{{ $menu->custom_id }}</td>
                                                    <td style="width: 30%">{{ $menu->name }}</td>
                                                    <td style="width: 30%">{{ formatRupiah($menu->price) }}</td>
                                                    <td style="width: 10%">
                                                        <input type="number" class="form-control" name="quantity" min="0" required>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <button type="submit" class="btn btn-success">Tambah</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <p class="text-center"><em>There is no record.</em></p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <h5 class="mt-5 mb-3">Minuman</h5>
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        @forelse($menus->where('type', \App\Models\Menu::MINUMAN) as $menu)
                                        <tr>
                                            <form action="{{ route('admin.order.store')}}" enctype="multipart/form-data" method="post"
                                            class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                                            @csrf
                                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <td style="width: 20%">{{ $menu->custom_id }}</td>
                                                <td style="width: 30%">{{ $menu->name }}</td>
                                                <td style="width: 30%">{{ formatRupiah($menu->price) }}</td>
                                                <td style="width: 10%">
                                                    <input type="number" class="form-control" name="quantity" min="0" required>
                                                </td>
                                                <td style="width: 10%">
                                                    <button type="submit" class="btn btn-success">Tambah</button>
                                                </td>
                                            </form>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <p class="text-center"><em>There is no record.</em></p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content>
    <script>
        const moneyInput = document.getElementById('moneyInput');
        const inputText = document.getElementById('inputText');
        const change = document.getElementById('change');
        
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
        }

        moneyInput.addEventListener('input', () => {
            const enteredAmount = parseFloat(moneyInput.value) || 0;
            
            const subtotal = {{ $reservation->orders->sum(function($order) {
                return $order->menu->price * $order->quantity;
            }) }};
            
            const diff = enteredAmount - subtotal;
            change.textContent = `Kembalian: ${formatRupiah(diff)}`;

            const invoiceUrl = `{{ route('admin.cashier.invoice2', ['reservation' => $reservation->id]) }}?enteredAmount=${enteredAmount}&change=${diff}`;
            printInvoiceBtn.href = invoiceUrl;
        });


    </script>

@endsection

