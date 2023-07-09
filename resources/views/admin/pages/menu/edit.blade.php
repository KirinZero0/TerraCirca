@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('css')

@endsection

@section('js')
<script>
      $('.custom-file-input').on('change', function (event) {
        var inputFile = event.currentTarget;
        $(inputFile).siblings('.custom-file-label').text(inputFile.files[0].name);
    });
</script>
@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit Menu'])
        </x-slot>
        <div>
            <form action="{{ route('admin.menu.update' , $menu->id) }}" enctype="multipart/form-data" method="post"
                    class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @method('PUT')
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
                                    <label>Nama Menu</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $menu->name }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Kode Menu</label>
                                    <input type="text" class="form-control" name="custom_id"
                                        value="{{ $menu->custom_id }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="price"
                                        value="{{ $menu->price }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Menu</label>
                                    <textarea class="form-control" name="description" required>{{ $menu->description }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select class="form-control" name="type" required>
                                        <option value="{{ \App\Models\Menu::MAKANAN }}" {{ $menu->type === \App\Models\Menu::MAKANAN ? 'selected' : '' }}>
                                            Makanan
                                        </option>
                                        <option value="{{ \App\Models\Menu::MINUMAN }}" {{ $menu->type === \App\Models\Menu::MINUMAN ? 'selected' : '' }}>
                                            Minuman
                                        </option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02" name="photo" accept="image/*" >
                                        <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">{{ $menu->photo }}</label>
                                    </div>
                                </div>
                            
                                @if ($menu->photo)
                                <div>
                                    <img src="{{ $menu->getImageUrl() }}" class="img-thumbnail" alt="Menu Photo">
                                </div>
                                @endif
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
