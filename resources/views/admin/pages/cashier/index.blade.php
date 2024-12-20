@extends('layouts.admin')

@section('title', 'Orders')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Orders</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Order</h4>
                <div class="card-header-form row">
                    <div>
                        <form>
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian"
                                    value="{{ Request::input('search') ?? ''}}">
                                <div class="input-group-btn">
                                    <button style="background-color: rgb(26, 85, 36)" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ml-2">
                        <a href="{{ route('admin.reservation.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                            Tambah Data <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </x-slot>

            <x-slot name="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Reference Id</th>
                            <th>Atas Nama</th>
                            <th>Nomor Meja</th>
                            <th>Tanggal</th>
                            <th style="width:150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $loop->index + $reservations->firstItem() }}</td>
                                <td>{{ $reservation->reference_id }}</td>
                                <td>{{ $reservation->name }}</td>
                                <td>{{ $reservation->table_number }}</td>
                                <td>{{ $reservation->date->format('H:i - F j, Y ') }}</td>
                                <td>
                                    <button class="btn btn-success position-relative" data-toggle="collapse" data-target="#orderAccordion{{ $reservation->id }}">
                                        <i class="fas fa-caret-square-down"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <div id="orderAccordion{{ $reservation->id }}" class="collapse">
                                        <!-- Orders content -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nama Menu</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="text-center">Harga</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                                </thead>
                                            <tbody>
                                                @foreach($reservation->orders as $order)
                                                    <tr>
                                                        <td class="text-center"><strong>{{ $order->menu->name }}</strong></td>
                                                        <td class="text-center"><strong>x{{ $order->quantity }}</strong></td>
                                                        <td class="text-center"><strong>{{ formatRupiah($order->menu->price) }}</strong></td>
                                                        <td class="text-center"><strong>{{ formatRupiah($order->menu->price * $order->quantity) }}</strong></td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" class="text-center"><strong>Subtotal</strong></td>
                                                    <td colspan="1" class="text-center"> 
                                                        <strong>
                                                            {{ formatRupiah($reservation->orders->sum(function($order) {
                                                                return $order->menu->price * $order->quantity;
                                                            })) }}
                                                        </strong> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <a class="btn btn-success btn-lg" href="{{route('admin.reservation.invoice', $reservation->id)}}">Invoice</a>
                                                    </td>
                                                    <td colspan="1" class="text-center">
                                                        <a class="btn btn-primary btn-md" href="{{ route('admin.reservation.finish', $reservation->id)}}">Finish</a>
                                                        <a class="btn btn-warning btn-md" href="{{ route('admin.reservation.cancel', $reservation->id) }}">Cancel</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="orderModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderModalLabel">Orders for {{ $reservation->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                @foreach($reservation->orders as $order)
                                                    <li>{{ $order->name }} - {{ $order->quantity }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            </x-slot>

            <x-slot name="footer">
                {{ $reservations->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
