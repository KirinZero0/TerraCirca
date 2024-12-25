@extends('layouts.admin')

@section('title', 'Laporan Produk Keluar')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Laporan Produk Keluar</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Laporan Produk Keluar</h4>
                <div class="card-header-form row">
                    <form method="GET" action="" class="d-flex align-items-center">
                        <!-- Year Selector -->
                        <div class="input-group mr-2">
                            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                <option value="">Pilih Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request()->get('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Month Selector -->
                        <div class="input-group">
                            <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                                <option value="">Pilih Bulan</option>
                                @foreach($months as $key => $month)
                                    <option value="{{ $key + 1 }}" {{ request()->get('month') == $key + 1 ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group">
                            <select name="type" id="type" class="form-control" onchange="this.form.submit()">
                                <option value="">Pilih Tipe</option>
                                @foreach($productOutTypes as $type)
                                    <option value="{{ $type }}" {{ request()->get('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
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
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Type</th>
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
