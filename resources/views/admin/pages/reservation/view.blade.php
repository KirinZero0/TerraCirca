@extends('layouts.admin')

@section('title', 'View')

@section('css')
    <style>
        .unclickable-div {
            position: relative;
            pointer-events: none;
        }

        .unclickable-div::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
    </style>
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
                            </p>     
                            @empty
                            <p class="card-text">Order Kosong</p>
                            @endforelse
                            <a class="btn btn-success" href="{{route('admin.reservation.invoice', $reservation->id)}}">Print Invoice</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12 ">
                    <div class="card unclickable-div">
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

@endsection
