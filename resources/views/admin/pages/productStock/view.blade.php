@extends('layouts.admin')

@section('title', 'Stok')

@section('css')
<style>
    .striked {
        text-decoration: line-through;
        color: gray;
    }
</style>
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
                        @if($stock->status != 'Unavailable')
                            <a href="{{ route('admin.product.product_stock.edit', $stock->id) }}"
                                class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            {{$stock->name}} <span class="badge badge-secondary">{{$stock->barcode}}</span>
                            @if($stock->status == 'Expired')
                                <i class="fa fa-exclamation text-danger" title="Expired"></i>
                            @elseif($stock->status == 'Near Expired')
                                <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                            @endif
                        </h5>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Batch: {{$stock->batch}}</p>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Stok: {{$stock->stock}}</p>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Harga: {{$stock->selling_price}}</p>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Status: {{$stock->status}}</p>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Harga: {{formatRupiah($stock->selling_price)}}</p>
                        <p class="card-text {{ $stock->status == 'Unavailable' ? 'striked' : '' }}">Exp: {{$stock->expiration_date->format('F j, Y')}}</p>
                    </div>
                    @if($stock->status != 'Unavailable')
                        <a href="#" 
                            data-toggle="tooltip"
                            data-placement="top" 
                            title="Mark as Unavailable" 
                            class="btn btn-sm btn-danger delete"
                            onclick="event.preventDefault(); document.getElementById('mark-unavailable-form-{{ $stock->id }}').submit();">
                            <i class="fas fa-trash"></i>
                        </a>
                    
                        <form id="mark-unavailable-form-{{ $stock->id }}" action="{{ route('admin.product.product_stock.unavailable', $stock->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PATCH')
                        </form>
                    @endif
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
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @forelse($productOuts as $productOut)
                                        <tr>
                                                <td style="width: 20%" class="{{ $stock->status == 'Unavailable' ? 'striked' : '' }}">{{ $productOut->type }}</td>
                                                <td style="width: 30%" class="{{ $stock->status == 'Unavailable' ? 'striked' : '' }}">{{ $productOut->quantity }}</td>
                                                <td style="width: 30%" class="{{ $stock->status == 'Unavailable' ? 'striked' : '' }}">{{ $productOut->created_at->format('F j, Y H:i') }}</td>
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
                <div class="card">
                    <div class="card-header">
                        <h4>Audits</h4>
                        <div class="ml-2">
                            <a href="{{ route('admin.product.product_stock.audit.create', $stock->id) }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>      
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>Previous Stock</th>
                                        <th>Audited Stock</th>
                                        <th>Note</th>
                                        <th>Date</th>
                                        <th>Auditor</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @forelse($audits as $audit)
                                        <tr>
                                                <td style="width: 20%">{{ $audit->previous_stock }}</td>
                                                <td style="width: 20%">{{ $audit->audited_stock }}</td>
                                                <td style="width: 30%">{{ $audit->note }}</td>
                                                <td style="width: 30%">{{ $audit->audit_date->format('F j, Y H:i') }}</td>
                                                <td style="width: 30%">{{ $audit->admin->name }}</td>
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