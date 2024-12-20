@extends('layouts.admin')

@section('title', 'List Barang')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>List Produk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data List Produk</h4>
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
                        <a href="{{ route('admin.barang.list.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
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
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th style="width:150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->index + $products->firstItem() }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <a href="{{ route('admin.barang.list.edit', $product->id) }}"
                                        class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Edit">
                                         <i class="far fa-edit"></i>
                                     </a>
                                    <a href="{{ route('admin.barang.list.destroy', $product->id) }}" data-toggle="tooltip"
                                       data-placement="top" title="" data-original-title="Delete"
                                       class="btn btn-sm btn-danger delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
