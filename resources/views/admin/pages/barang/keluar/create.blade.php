@extends('layouts.admin')

@section('title', 'Barang Keluar')

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

        $(document).ready(function() {
            $('#product_name').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var maxQuantity = selectedOption.data('max-quantity');

                // Set the max attribute of the quantity input field
                $('input[name="quantity"]').attr('max', maxQuantity);
            });

            $('input[name="quantity"]').on('input', function() {
                var maxQuantity = $(this).attr('max');
                var enteredQuantity = parseInt($(this).val());

                // Validate the entered quantity
                if (enteredQuantity > maxQuantity) {
                    $(this).val(maxQuantity);
                }
            });
        });
    </script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Barang Keluar'])
        </x-slot>
        <div>
            <form action="{{ route('admin.barang.keluar.store') }}" enctype="multipart/form-data" method="post"
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
                                    <label>Nama Barang</label>
                                    <select class="custom-select" id="product_name" name="name">
                                        <option selected="">Pilih Barang</option>
                                        @foreach($lists as $list)
                                            <option value="{{ $list->custom_id }}" data-max-quantity="{{ $list->productStock->stock }}">{{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input type="text" class="form-control" name="code" id="product_code" value="{{ old('code') }}"
                                           required readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control" name="quantity" min="0"
                                           value="{{ old('quantity') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                               <div class="form-group">
                                    <label>Tipe</label>
                                    <select class="form-control" name="type" id="product_type_select" required>
                                        <option value="{{ \App\Models\ProductOut::KELUAR }}">Barang Keluar</option>
                                        <option value="{{ \App\Models\ProductOut::RETURN }}">Barang Retur</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Alasan</label>
                                    <textarea class="form-control" name="reasons">{{ old('reasons') }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label id="product_type_view">Tanggal Keluar</label>
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
