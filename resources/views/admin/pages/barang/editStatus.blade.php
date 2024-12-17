@extends('layouts.admin')

@section('title', 'Edit Status Barang')

@section('css')

@endsection

@section('js')
    <script src="{{  asset('stisla/js/upload-image.js') }}"></script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit Status Barang'])
        </x-slot>
        <div>
            <form action="{{ route('admin.barang.updateStatus', $product->id) }}" enctype="multipart/form-data" method="post"
                  class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12 col-sm-12 my-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>Status Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-title mt-0">Ubah Status Barang</div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="{{ \App\Models\Product::APPROVED }}">Setujui</option>
                                        <option value="{{ \App\Models\Product::REJECTED }}">Tolak</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Alasan Jika Ditolak (optional)</label>
                                    <textarea class="form-control" name="reasons">{{ old('reasons') }}</textarea>
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
