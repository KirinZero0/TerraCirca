@extends('layouts.admin')

@section('title', 'Stok')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.product.product_stock.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Stok
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Stok</h4>
                            <a href="{{ route('admin.product.product_stock.edit', $stock->id) }}"
                                class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                 <i class="far fa-edit"></i>
                             </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$stock->name}} <span class="badge badge-secondary">{{$stock->productList->code}}</span>
                                @if($stock->status == 'Expired')
                                <i class="fa fa-exclamation text-danger" title="Expired"></i>
                            @elseif($stock->status == 'Near Expired')
                                <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                            @endif
                        </h5>
                            <p class="card-text">Barcode: {{$stock->barcode}}</p>
                            <p class="card-text">Stok: {{$stock->stock}}</p>
                            <p class="card-text">Harga: {{$stock->selling_price}}</p>
                            <p class="card-text">Status: {{$stock->status}}</p>
                            <p class="card-text">Harga: {{formatRupiah($stock->selling_price)}}</p>
                            <p class="card-text">Exp: {{$stock->expiration_date->format('F j, Y')}}</p>
                            </p>  
                        </div>
                        <a href="{{ route('admin.product.product_stock.destroy', $stock->id) }}" data-toggle="tooltip"
                            data-placement="top" title="" data-original-title="Delete"
                            class="btn btn-sm btn-danger delete">
                             <i class="fas fa-trash"></i>
                         </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>History</h4>
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
                                        @forelse($productOuts as $productOut)
                                            <tr>
                                                    <td style="width: 20%">{{ $productOut->type }}</td>
                                                    <td style="width: 30%">{{ $productOut->quantity }}</td>
                                                    <td style="width: 30%">{{ $productOut->stock }}</td>
                                                    <td style="width: 30%">{{ $productOut->date->format('F j, Y') }}</td>
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

