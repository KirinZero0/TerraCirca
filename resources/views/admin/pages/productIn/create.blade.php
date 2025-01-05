@extends('layouts.admin')

@section('title', 'Tambah Produk Masuk')

@section('css')

@endsection

@section('js')
    <script>
        const productName = document.getElementById('product_name');
        const productCode = document.getElementById('product_code');

        productName.addEventListener("change", (e) => {
            productCode.value = e.target.value;
        });

        const productTypeSelect = document.getElementById('product_type_select');
        const productTypeView = document.getElementById('product_type_view');

        productTypeSelect.addEventListener("change", (e) => {
            productTypeView.innerHTML = e.srcElement.options[e.srcElement.selectedIndex].text;
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('product_search');
            const productDropdown = document.getElementById('product_name');
    
            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
    
                // Loop through all options
                Array.from(productDropdown.options).forEach(option => {
                    if (option.value === '') return; // Ignore placeholder option
    
                    // Use the "data-name" attribute for a consistent lowercase comparison
                    const optionText = option.getAttribute('data-name');
                    option.hidden = !optionText.includes(searchValue);
                });
            });
        });
    </script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Tambah Produk Masuk'])
        </x-slot>
        <div>
            <form action="{{ route('admin.product.product_in.store') }}" enctype="multipart/form-data" method="post"
                  class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12 my-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Dasar</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-title mt-0">Informasi Dasar</div>
                                <div class="form-group">
                                    <label>Product</label>
                                    <!-- Search input -->
                                    <input type="text" id="product_search" class="form-control mb-2" placeholder="Search product..." />
                                
                                    <!-- Product dropdown -->
                                    <select class="custom-select" id="product_name" name="product_list_id" required size="5">
                                        <option value="" disabled selected hidden>Select a Product</option>
                                        @foreach($lists as $list)
                                            <option value="{{ $list->id }}" data-name="{{ strtolower($list->name) }}">
                                                {{ $list->name }} / {{ $list->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a product from the list.</div>
                                </div>
                                <div class="form-group">
                                    <label>Price per piece</label>
                                    <input type="text" class="form-control" name="price"
                                           value="{{ old('price') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Selling Price per piece</label>
                                    <input type="text" class="form-control" name="selling_price"
                                           value="{{ old('selling_price') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" name="quantity" min="0"
                                           value="{{ old('quantity') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Batch/Barcode</label>
                                    <input type="text" class="form-control" name="barcode" min="0"
                                           value="{{ old('barcode') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label id="product_type_view">Expiration Date</label>
                                    <input type="date" class="form-control" name="expiration_date"
                                           value="{{ old('expiration_date') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
    {{--                            <div class="form-group">
                                    <label>Tipe</label>
                                    <select class="form-control" name="type" id="product_type_select" required>
                                        <option value="{{ \App\Models\Product::MASUK }}">Barang Masuk</option>
                                        <option value="{{ \App\Models\Product::KELUAR }}">Barang Keluar</option>
                                        <option value="{{ \App\Models\Product::RETURN }}">Barang Retur</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>--}}
                                <div class="form-group">
                                    <label id="product_type_view">Date</label>
                                    <input type="date" class="form-control" name="date"
                                           value="{{ old('date') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="mx-1">
                                <a href="{{ url()->previous() }}" class="btn border bg-white" type="button">Kembali</a>
                            </div>
                            <div class="mx-1">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </x-content>

@endsection
