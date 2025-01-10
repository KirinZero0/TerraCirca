@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('css')

@endsection

@section('js')
    <script src="{{  asset('stisla/js/upload-image.js') }}"></script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit Produk'])
        </x-slot>
        <div>
            <form action="{{ route('admin.product.product_list.update', $productList->id) }}" enctype="multipart/form-data" method="post"
                  class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @csrf
                @method('PATCH')
                <div class="row">
                    {{--                    <div class="col-md-4 col-sm-12 my-1">--}}
                    {{--                        @include('admin.pages.barang.partials.image-upload', ['imageUrl' => $supplier->getImageUrl()])--}}
                    {{--                    </div>--}}
                    <div class="col-md-12 col-sm-12 my-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Dasar</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-title mt-0">Informasi Dasar</div>
                                
                                <!-- Code -->
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $productList->code) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <!-- Name -->
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $productList->name) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <!-- Category -->
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category" id="product_category_select" required>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::OBAT_BEBAS }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::OBAT_BEBAS ? 'selected' : '' }}>
                                            Obat Bebas
                                        </option>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::OBAT_BEBAS_TERBATAS }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::OBAT_BEBAS_TERBATAS ? 'selected' : '' }}>
                                            Obat Bebas Terbatas
                                        </option>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::OBAT_KERAS }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::OBAT_KERAS ? 'selected' : '' }}>
                                            Obat Keras
                                        </option>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::OBAT_GENERIC }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::OBAT_GENERIC ? 'selected' : '' }}>
                                            Obat Keras
                                        </option>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::OBAT_PATENT }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::OBAT_PATENT ? 'selected' : '' }}>
                                            Obat Keras
                                        </option>
                                        <option value="{{ \App\Enums\ProductListCategoryEnum::LAINNYA }}" 
                                            {{ $productList->category == \App\Enums\ProductListCategoryEnum::LAINNYA ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group">
                                    <label>Indication</label>
                                    <input type="text" class="form-control" name="indication" value="{{ old('indication', $productList->indication) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <!-- Type -->
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" id="product_type_select" required>
                                        <option value="{{ \App\Enums\ProductListTypeEnum::STRIP }}" 
                                            {{ $productList->type == \App\Enums\ProductListTypeEnum::STRIP ? 'selected' : '' }}>
                                            Strip
                                        </option>
                                        <option value="{{ \App\Enums\ProductListTypeEnum::TABLET }}" 
                                            {{ $productList->type == \App\Enums\ProductListTypeEnum::TABLET ? 'selected' : '' }}>
                                            Tablet
                                        </option>
                                        <option value="{{ \App\Enums\ProductListTypeEnum::BOTOL }}" 
                                            {{ $productList->type == \App\Enums\ProductListTypeEnum::BOTOL ? 'selected' : '' }}>
                                            Botol
                                        </option>
                                        <option value="{{ \App\Enums\ProductListTypeEnum::BOX }}" 
                                            {{ $productList->type == \App\Enums\ProductListTypeEnum::BOX ? 'selected' : '' }}>
                                            Box
                                        </option>
                                        <option value="{{ \App\Enums\ProductListTypeEnum::SACHET }}" 
                                            {{ $productList->type == \App\Enums\ProductListTypeEnum::SACHET ? 'selected' : '' }}>
                                            Sachet
                                        </option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <!-- Supplier -->
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <!-- Search input -->
                                    <input type="text" id="product_search" class="form-control mb-2" placeholder="Search supplier...." />
                                    
                                    <!-- Supplier dropdown -->
                                    <select class="custom-select" id="product_name" name="supplier_id" required size="5">
                                        <option value="" disabled hidden>Select a Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" 
                                                {{ $productList->supplier_id == $supplier->id ? 'selected' : '' }}
                                                data-name="{{ strtolower($supplier->name) }}">
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
