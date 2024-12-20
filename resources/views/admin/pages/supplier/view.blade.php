@extends('layouts.admin')

@section('title', 'Supplier')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.supplier.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Supplier
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Supplier</h4>
                            <a href="{{ route('admin.supplier.edit', $supplier->id) }}"
                                class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                 <i class="far fa-edit"></i>
                             </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$supplier->name}} <span class="badge badge-secondary">{{$supplier->id}}</span></h5>
                            <p class="card-text">Alamat: {{$supplier->address}}</p>
                            <p class="card-text">Telp: {{$supplier->phone}}</p>
                            <p class="card-text">Email: {{$supplier->email}}</p>
                            <p class="card-text">Deskripsi: {{$supplier->description}}</p>
                            </p>  
                        </div>
                        <a href="{{ route('admin.supplier.destroy', $supplier->id) }}" data-toggle="tooltip"
                            data-placement="top" title="" data-original-title="Delete"
                            class="btn btn-sm btn-danger delete">
                             <i class="fas fa-trash"></i>
                         </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Produk</h4>
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
                                        @forelse($lists as $list)
                                            <tr>
                                                    <td>
                                                        <a href="{{ route('admin.product.product_list.show', $list->id) }}" 
                                                            class="d-inline-block text-decoration-none badge badge-primary">
                                                            {{ $list->code }}
                                                        </a>
                                                    </td>
                                                    <td style="width: 30%">{{ $list->name }}</td>
                                                    <td style="width: 30%">{{ $list->category }}</td>
                                                    <td style="width: 30%">{{ $list->type }}</td>
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

