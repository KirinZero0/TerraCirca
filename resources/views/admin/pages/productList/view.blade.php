@extends('layouts.admin')

@section('title', 'Produk')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.product.product_list.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Produk
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Produk</h4>
                            <a href="{{ route('admin.product.product_list.edit', $product->id) }}"
                                class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                 <i class="far fa-edit"></i>
                             </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}} <span class="badge badge-secondary">{{$product->code}}</span></h5>
                            <p class="card-text">Supplier: {{$product->supplier->name}}</p>
                            <p class="card-text">Kategori: {{$product->productCategory->name}}</p>
                            <p class="card-text">Tipe: {{$product->type}}</p>
                            </p>  
                        </div>
                        <a href="{{ route('admin.product.product_list.destroy', $product->id) }}" data-toggle="tooltip"
                            data-placement="top" title="" data-original-title="Delete"
                            class="btn btn-sm btn-danger delete">
                             <i class="fas fa-trash"></i>
                         </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Stock</h4>
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
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        @forelse($stocks as $stock)
                                            <tr>
                                                    <td>
                                                        <a href="{{ route('admin.product.product_stock.show', $stock->id) }}" 
                                                            class="d-inline-block text-decoration-none badge badge-primary">
                                                            {{ $stock->barcode }}
                                                        </a>
                                                    </td>
                                                    <td style="width: 30%">{{ $stock->name }}</td>
                                                    <td style="width: 30%">{{ $stock->stock }}</td>
                                                    <td style="width: 30%">{{ $stock->status }}
                                                        @if($stock->status == 'Expired')
                                                        <i class="fa fa-exclamation text-danger" title="Expired"></i>
                                                    @elseif($stock->status == 'Near Expired')
                                                        <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content>


@endsection

