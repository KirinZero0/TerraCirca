@extends('layouts.admin')

@section('title', 'Kelola Barang Masuk')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kelola Barang Masuk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Barang Masuk</h4>
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
                    <div class="ml-2">
                        <a href="{{ route('admin.barang.create') }}" style="background-color: rgb(70, 147, 177)" class="btn btn-sm btn-primary">
                            Tambah Barang <i class="fas fa-plus"></i>
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
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th style="width:150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->index + $products->firstItem() }}</td>
                                <td>{{ $product->product['custom_id'] }}</td>
                                <td>{{ $product->product['name'] }}</td>
                                <td>{{ formatRupiah($product->price) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->date->format('F j, Y') }}</td>
                                <td>
                                    <span class="{{ $product->getStatusColor() }}">{{ $product->getStatus() }}@if(!blank($product->reasons)){{ ': ' . $product->reasons }} @endif</span>
                                </td>
                                <td>
                                    @if($product->status !== \App\Models\Product::APPROVED && $product->status !== \App\Models\Product::REJECTED)
                                        <a href="{{ route('admin.barang.editStatus', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-success" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Update Status">
                                            <i class="fas fa-question"></i>
                                        </a>
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
                                        <a href="{{ route('admin.barang.edit', $product->id) }}"
                                           class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.barang.destroy', $product->id) }}" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Delete"
                                           class="btn btn-sm btn-danger delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
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
                {{ $products->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
