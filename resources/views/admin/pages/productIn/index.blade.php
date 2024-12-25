@extends('layouts.admin')

@section('title', 'Kelola Barang Masuk')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kelola Produk Masuk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Produk Masuk</h4>
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
                        <a href="{{ route('admin.product.product_in.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                            Tambah Produk <i class="fas fa-plus"></i>
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
                            <th>Name</th>
                            <th>Price per piece</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            {{-- <th style="width:150px">Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($productIns as $productIn)
                            <tr>
                                <td>{{ $loop->index + $productIns->firstItem() }}</td>
                                <td>{{ $productIn->productList->name }}</td>
                                <td>{{ formatRupiah($productIn->price) }}</td>
                                <td>{{ $productIn->quantity }}</td>
                                <td>{{ $productIn->date->format('F j, Y') }}</td>
                                {{-- <td>
                                        <a href="{{ route('admin.barang.editStatus', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-success" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Update Status">
                                            <i class="fas fa-question"></i>
                                        </a> --}}
                                        {{-- <a href="{{ route('admin.barang.return.edit', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Retur">
                                            <i class="fas fa-undo-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.barang.keluar.edit', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-info" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Edit Tipe">
                                            <i class="fas fa-exchange-alt"></i>
                                        </a> --}}
                                        {{-- <a href="{{ route('admin.barang.edit', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.barang.destroy', $product->id) }}" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Delete"
                                           class="btn btn-sm btn-danger delete">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}
                                {{-- </td> --}}
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
            </x-slot>

            <x-slot name="footer">
                {{ $productIns->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
