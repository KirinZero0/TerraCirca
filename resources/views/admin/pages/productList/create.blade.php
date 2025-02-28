@extends('layouts.admin')

@section('title', 'Tambah List Produk')

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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const searchInput = document.getElementById('category_search');
                const categoryDropdown = document.getElementById('category_name');
        
                searchInput.addEventListener('input', function () {
                    const searchValue = this.value.toLowerCase();
        
                    // Loop through all options
                    Array.from(categoryDropdown.options).forEach(option => {
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
            @include('admin.partials.back-with-title', ['title' => 'Tambah List Produk'])
        </x-slot>
        <div>
            <form action="{{ route('admin.product.product_list.store') }}" enctype="multipart/form-data" method="post"
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
                                    <label>Code</label>
                                    <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}"
                                           required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <!-- Search input -->
                                    <input type="text" id="category_search" class="form-control mb-2" placeholder="Search category...." />
                                
                                    <!-- Product dropdown -->
                                    <select class="custom-select" id="category_name" name="product_category_id" required size="5">
                                        <option value="" disabled selected hidden>Select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" data-name="{{ strtolower($category->name) }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a category from the list.</div>
                                </div>
                                <div class="form-group">
                                    <label>Barcode</label>
                                    <input type="text" class="form-control" name="barcode"
                                           value="{{ old('barcode') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Indication</label>
                                    <input type="text" class="form-control" name="indication"
                                           value="{{ old('indication') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" id="product_type_select" required>
                                        <option value="{{\App\Enums\ProductListTypeEnum::STRIP}}">Strip</option>
                                        <option value="{{\App\Enums\ProductListTypeEnum::TABLET}}">Tablet</option>
                                        <option value="{{\App\Enums\ProductListTypeEnum::BOTOL}}">Botol</option>
                                        <option value="{{\App\Enums\ProductListTypeEnum::BOX}}">Box</option>
                                        <option value="{{\App\Enums\ProductListTypeEnum::SACHET}}">Sachet</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <!-- Search input -->
                                    <input type="text" id="product_search" class="form-control mb-2" placeholder="Search supplier...." />
                                
                                    <!-- Product dropdown -->
                                    <select class="custom-select" id="product_name" name="supplier_id" required size="5">
                                        <option value="" disabled selected hidden>Select a Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" data-name="{{ strtolower($supplier->name) }}">
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a supplier from the list.</div>
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
