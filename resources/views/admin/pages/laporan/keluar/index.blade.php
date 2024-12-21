@extends('layouts.admin')

@section('title', 'Laporan Barang Keluar')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Laporan Barang Keluar</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Laporan Barang Keluar</h4>
                <div class="card-header-form row">
                    <div>
                        <form>
                            <div class="input-group">
                                <select type="text" class="form-control" name="type" id="product_type_select" required
                                        onchange="this.form.submit()">
                                    <option value="">Pilih Tipe</option>
                                    <option @if(request()->get('type') == \App\Enums\ProductOutTypeEnum::RETUR) selected @endif value="{{ \App\Enums\ProductOutTypeEnum::RETUR }}">Retur</option>
                                    <option @if(request()->get('type') == \App\Enums\ProductOutTypeEnum::DEFECT) selected @endif value="{{ \App\Enums\ProductOutTypeEnum::DEFECT }}">Rusak</option>
                                    <option @if(request()->get('type') == \App\Enums\ProductOutTypeEnum::TRANSACTION) selected @endif value="{{ \App\Enums\ProductOutTypeEnum::TRANSACTION }}">Transaksi</option>
                                    <option @if(request()->get('type') == \App\Enums\ProductOutTypeEnum::EXPIRED) selected @endif value="{{ \App\Enums\ProductOutTypeEnum::EXPIRED }}">Expire</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div>
                        <form>
                            <div class="input-group">
                                <select type="text" name="month" id="month" class="form-control"
                                        onchange="this.form.submit()">
                                    <option value="">Pilih Bulan</option>
                                    @foreach($months as $key => $month)
                                        <option @if($key + 1 == request()->get('month')) selected
                                                @endif value="{{ $key + 1 }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="ml-2">
                        <a href="{{ route('admin.laporan.keluar.export') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-primary">
                            Export Data <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </x-slot>

            <x-slot name="body">
                <div class="table-responsive">
                    <table class="table table-bordered  table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tanggal Keluar/Retur</th>
                            <th>Tipe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->index + $products->firstItem() }}</td>
                                <td>{{ $product->productStock->barcode }}</td>
                                <td>{{ $product->productStock->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->date->format('F j, Y') }}</td>
                                <td>{{ $product->type }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
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
