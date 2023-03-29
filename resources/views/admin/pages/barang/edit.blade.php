@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('css')

@endsection

@section('js')
    <script src="{{  asset('stisla/js/upload-image.js') }}"></script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit Barang'])
        </x-slot>
        <div>
            <form action="{{ route('admin.barang.update', $product->id) }}" enctype="multipart/form-data" method="post"
                  class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 col-sm-12 my-1">
                        @include('admin.pages.barang.partials.image-upload', ['imageUrl' => $product->getImageUrl()])
                    </div>
                    <div class="col-md-8 col-sm-12 my-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Dasar</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-title mt-0">Informasi Dasar</div>
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input type="text" class="form-control" name="code" value="{{ $product->code }}"
                                           required readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}"
                                           required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="price"
                                           value="{{ old('price', $product->price) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control" name="quantity"
                                           value="{{ old('quantity', $product->quantity) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select class="form-control" name="type" required>
                                        <option @if($product->type == \App\Models\Product::MASUK) selected @endif value="{{ \App\Models\Product::MASUK }}">Barang Masuk</option>
                                        <option @if($product->type == \App\Models\Product::KELUAR) selected @endif value="{{ \App\Models\Product::KELUAR }}">Barang Keluar</option>
                                        <option @if($product->type == \App\Models\Product::RETURN) selected @endif value="{{ \App\Models\Product::RETURN }}">Barang Return</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="date"
                                           value="{{ old('date', $product->date->format('Y-m-d')) }}" required>
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
