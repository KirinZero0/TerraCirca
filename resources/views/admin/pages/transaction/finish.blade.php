@extends('layouts.admin')

@section('title', 'Transaksi')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.transaction.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Transaksi
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$transaction->reference_id}}</h5>
                            <p class="card-text">{{$transaction->date->format('F j, Y')}}</p>
                            <!-- Patient Selection -->
                            <div class="d-flex align-items-center mb-3">
                                @if($transaction->patient)
                                    <p class="card-text mb-0">{{ $transaction->patient->name. ' - ' . $transaction->patient->phone }}</p>
                                @else
                                    Transaksi tanpa data pasien
                                @endif
                            </div>
                            <p class="card-title">Subtotal: 
                                    <strong>
                                    {{formatRupiah($transaction->total_amount)}}
                                    </strong>  
                            </p>
                            <p class="card-title">Dibayar: 
                                    <strong>
                                    {{formatRupiah($transaction->paid_amount)}}
                                    </strong>  
                            </p>
                            <p class="card-title">Kembalian: 
                                    <strong>
                                    {{formatRupiah($transaction->change_amount)}}
                                    </strong>  
                            </p>
                            {{-- <a id="printInvoiceBtn" class="btn btn-success" href="{{route('admin.cashier.invoice2', $reservation->id)}}">Print Invoice</a> --}}
                        </div>
                        {{-- <a href="{{ route('admin.supplier.destroy', $supplier->id) }}" data-toggle="tooltip"
                            data-placement="top" title="" data-original-title="Delete"
                            class="btn btn-sm btn-danger delete">
                             <i class="fas fa-trash"></i>
                         </a> --}}
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
                                        @forelse($items as $item)
                                            <tr>
                                                    <td>
                                                        <a href="{{ route('admin.product.product_stock.show', $item->productStock->id) }}" 
                                                            class="d-inline-block text-decoration-none badge badge-primary">
                                                            {{ $item->productStock->name }}
                                                        </a>
                                                    </td>
                                                    <td style="width: 30%">{{ $item->productStock->selling_price }}</td>
                                                    <td style="width: 30%">{{ $item->quantity }}</td>
                                                    <td style="width: 30%">{{ $item->total_amount }}</td>
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

