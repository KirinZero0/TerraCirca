@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('css')

@endsection

@section('js')
    <script src="{{  asset('stisla/js/upload-image.js') }}"></script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit Supplier'])
        </x-slot>
        <div>
            <form action="{{ route('admin.supplier.update', $supplier->id) }}" enctype="multipart/form-data" method="post"
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
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name', $supplier->name) }}"
                                           required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description"
                                           value="{{ old('description', $supplier->description) }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ old('address', $supplier->address) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{ old('phone', $supplier->phone) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email"
                                           value="{{ old('email', $supplier->email) }}" required>
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
