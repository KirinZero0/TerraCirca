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
                                    <button style="background-color: rgb(70, 147, 177)" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @canany(['owner', 'pegawai'])
                    <div class="ml-2">
                        <a href="{{ route('admin.reservation.create') }}" style="background-color: rgb(70, 147, 177)" class="btn btn-sm btn-primary">
                            Tambah Data <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    @endcanany
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
                            {{-- <th>Status</th> --}}
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
                                {{-- <td>
                                    <span class="{{ $reservation->getStatusColor() }}">{{ $reservation->getStatus() }}</span>
                                </td> --}}
                                <td>
                                    <button class="btn btn-success position-relative" data-toggle="collapse" data-target="#orderAccordion{{ $reservation->id }}">
                                        <i class="fas fa-caret-square-down"></i>
                                        @if ($reservation->pendingOrderCount > 0)
                                            <span style="top: -7px" class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                                {{ $reservation->pendingOrderCount }}
                                            </span>
                                        @endif
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
                                                    <th class="text-center">Status</th>
                                                </tr>
                                                </thead>
                                            <tbody>
                                                @foreach($reservation->orders as $order)
                                                    <tr>
                                                        <td class="text-center" style="width: 20%;"><strong>{{ $order->menu->name }}</strong></td>
                                                        <td class="text-center" style="width: 20%;"><strong>x{{ $order->quantity }}</strong></td>
                                                        <td class="text-center" style="width: 20%;">
                                                            @if($order->status === \App\Models\Order::DONE)
                                                            <a href="{{ route('admin.chef.cancel', $order->id) }}" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check-circle text-lg text-white"></i>
                                                            </a>
                                                            @else
                                                            <a href="{{ route('admin.chef.done', $order->id) }}" class="btn btn-danger btn-sm">
                                                                <i class="far fa-circle text-lg text-white"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
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
