@extends('layouts.admin')

@section('title', 'Kategori Produk')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kategori Produk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Kategori Produk</h4>
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
                        <a href="{{ route('admin.product.product_category.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                            Tambah Kategori <i class="fas fa-plus"></i>
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($productCategories as $productCategory)
                            <tr>
                                <td>{{ $loop->index + $productCategories->firstItem() }}</td>
                                <td>{{ $productCategory->name }}</td>
                                <td>
                                    <a href="{{ route('admin.product.product_category.edit', $productCategory->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit text-lg text-white"></i>
                                    </a>
                                    <a href="{{ route('admin.product.product_category.destroy', $productCategory->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash text-lg text-white"></i>
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
                {{ $productCategories->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
