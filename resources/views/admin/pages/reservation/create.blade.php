@extends('layouts.admin')

@section('title', 'Tambah Reservasi')

@section('css')

@endsection

@section('js')
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Tambah Reservasi'])
        </x-slot>
        <div>
            <form action="{{ route('admin.reservation.store') }}" enctype="multipart/form-data" method="post"
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
                                    <label>Reference Id</label>
                                    <input type="text" class="form-control" name="reference_id"
                                        value="{{ "RSV" . rand(100000, 999999) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Meja</label>
                                    <input type="number" class="form-control" name="table_number"
                                        value="{{ old('table_number') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Atas Nama</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Orang</label>
                                    <input type="number" class="form-control" name="number_of_people"
                                    value="{{ old('number_of_people') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label id="product_type_view">Tanggal Reservasi</label>
                                    <input type="datetime-local" class="form-control" name="date"
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
                                <button class="btn btn-primary" type="submit" name="submit_type" value="save">Simpan</button>
                            </div>
                            <div class="mx-1">
                                <button class="btn btn-warning" type="submit" name="submit_type" value="serve">Serve</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </x-content>

@endsection
