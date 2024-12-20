@extends('layouts.admin')

@section('title', 'Stok Produk')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Stok Produk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Stok Produk</h4>
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
                </div>
            </x-slot>

            <x-slot name="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Code</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Exp Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($productStocks as $productStock)
                            <tr>
                                <td>{{ $productStock->id }}</td>
                                <td>
                                    <a href="{{ route('admin.product.product_stock.show', $productStock->id) }}" 
                                        class="d-inline-block text-decoration-none badge badge-primary">
                                        {{ $productStock->barcode }}
                                    </a>
                                </td>
                                <td>{{ $productStock->productList->code }}</td>
                                <td>{{ $productStock->name }}</td>
                                <td>{{ $productStock->stock }}</td>
                                <td>
                                    {{ $productStock->expiration_date->format('F j, Y') }}
                                    
                                    @if($productStock->status == 'Expired')
                                        <i class="fa fa-exclamation text-danger" title="Expired"></i>
                                    @elseif($productStock->status == 'Near Expired')
                                        <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No product stocks available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </x-slot>

            <x-slot name="footer">
                {{ $productStocks->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
