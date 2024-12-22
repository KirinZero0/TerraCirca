@extends('layouts.admin')

@section('title', 'Kelola List Produk')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kelola List Produk</h1>
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
                        <a href="{{ route('admin.product.product_list.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
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
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Supplier</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($productLists as $productList)
                            <tr>
                                <td>{{ $loop->index + $productLists->firstItem() }}</td>
                                <td>
                                    <a href="{{ route('admin.product.product_list.show', $productList->id) }}" 
                                        class="d-inline-block text-decoration-none badge badge-primary">
                                        {{ $productList->code }}
                                    </a>
                                </td>
                                <td>{{ $productList->name }}</td>
                                <td>{{ $productList->category }}</td>
                                <td>{{ $productList->type }}</td>
                                <td>{{ $productList->supplier->name }}</td>
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
                {{ $productLists->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
