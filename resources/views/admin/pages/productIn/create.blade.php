@extends('layouts.admin')

@section('title', 'Tambah Barang')

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
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Tambah Barang'])
        </x-slot>
        <div>
            <form action="{{ route('admin.barang.store') }}" enctype="multipart/form-data" method="post"
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
                                    <select class="custom-select" id="product_name" name="product_list_id">
                                        <option selected="">Pilih Barang</option>
                                        @foreach($lists as $list)
                                            <option value="{{ $list->id }}">{{ $list->name }}</option>
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
                                    <label>Harga Satuan</label>
                                    <input type="text" class="form-control" name="price"
                                           value="{{ old('price') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control" name="quantity" min="0"
                                           value="{{ old('quantity') }}" required>
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
                                    <label id="product_type_view">Tanggal Masuk</label>
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
