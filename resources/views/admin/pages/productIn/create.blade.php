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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const priceInput = document.querySelector('input[name="price"]');
            const sellingPriceInput = document.querySelector('input[name="selling_price"]');
            
            // Create a profit and profit percentage display element
            const profitDisplay = document.createElement('div');
            const profitPercentageDisplay = document.createElement('div');
            
            profitDisplay.classList.add('text-info', 'mt-2'); // Add styling for profit
            profitPercentageDisplay.classList.add('text-info', 'mt-2'); // Add styling for profit percentage
            
            profitDisplay.innerHTML = "Profit: 0"; // Initial profit display
            profitPercentageDisplay.innerHTML = "Profit Percentage: 0%"; // Initial profit percentage display
            
            // Append both profit and percentage display below the selling price input field
            sellingPriceInput.parentElement.appendChild(profitDisplay);
            sellingPriceInput.parentElement.appendChild(profitPercentageDisplay);
            
            function calculateProfit() {
                // Parse the input values as floating-point numbers
                const price = parseFloat(priceInput.value) || 0;
                const sellingPrice = parseFloat(sellingPriceInput.value) || 0;
                
                const profit = sellingPrice - price; // Calculate the profit
                const profitPercentage = price > 0 ? ((profit / price) * 100).toFixed(2) : 0; // Calculate percentage
                
                // Update the profit display
                profitDisplay.innerHTML = `Profit: ${profit.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                })}`;
                
                // Update the profit percentage display
                profitPercentageDisplay.innerHTML = `Profit Percentage: ${profitPercentage}%`;
            }

            // Attach event listeners to the price and selling price fields
            priceInput.addEventListener('input', calculateProfit);
            sellingPriceInput.addEventListener('input', calculateProfit);
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
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Selling Price per piece</label>
                                    <input type="text" class="form-control" name="selling_price" value="{{ old('selling_price') }}" required>
                                    <!-- The profit will be dynamically displayed below this field -->
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" name="quantity" min="0"
                                           value="{{ old('quantity') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Barcode</label>
                                    <input type="text" class="form-control" name="barcode"
                                           value="{{ old('barcode') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Batch</label>
                                    <input type="text" class="form-control" name="batch"
                                           value="{{ old('batch') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label id="product_type_view">Expiration Date</label>
                                    <input type="date" class="form-control" name="expiration_date"
                                           value="{{ old('expiration_date') }}" required>
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
