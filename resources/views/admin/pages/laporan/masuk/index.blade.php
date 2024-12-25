@extends('layouts.admin')

@section('title', 'Laporan Produk Masuk')

@section('css')

@endsection

@section('js')
<script>
    const productTypeSelect = document.getElementById('product_type_select');
        const productTypeView = document.getElementById('product_type_view');

        productTypeSelect.addEventListener("change", (e) => {
            productTypeView.innerHTML = e.srcElement.options[e.srcElement.selectedIndex].text;
        });
</script>
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Laporan Produk Masuk</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Laporan Produk Masuk</h4>
                <div class="card-header-form row">
                    <!-- Filter Form -->
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
                    </form>
                    <div class="ml-2">
                        <a href="{{ route('admin.laporan.masuk.export') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-primary">
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
                            <th>Name</th>
                            <th>Price per piece</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->index + $products->firstItem() }}</td>
                                <td>{{ $product->productList->name }}</td>
                                <td>{{ formatRupiah($product->price) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->date->format('F j, Y') }}</td>
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
