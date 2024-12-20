@extends('layouts.admin')

@section('title', 'Menu')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Menu</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Menu</h4>
                <div class="card-header-form row">
                    <div>
                        <form>
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian"
                                    value="{{ Request::input('search') ?? ''}}">
                                <div class="input-group-btn">
                                    <button style="background-color: rgb(26, 85, 36)" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ml-2">
                        <a href="{{ route('admin.menu.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                            Tambah Menu <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="body">
                    <div class="row">
                    @forelse ($menus as $menu)
                        <div class="col-md-3">
                            <div class="card">
                                    <img src="{{  $menu->getImageUrl() }}" class="card-img-top" alt="..." style="width: 100%;  height: 15vw; object-fit: cover;" >
                                <div class="card-body">
                                    <h5 class="card-title">{{ $menu->name }} <span class="badge badge-secondary">{{ $menu->getType() }}</span></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $menu->custom_id }}</h6>
                                    <p class="card-text">{{ $menu->description }}</p>
                                    <p class="card-text">{{ formatRupiah($menu->price) }}</p>
                                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('admin.menu.destroy', $menu->id) }}" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8">
                                <p class="text-center"><em>There is no record.</em></p>
                            </td>
                        </tr>
                    @endforelse
                    </div>
            </x-slot>
            <x-slot name="footer">
                {{ $menus->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
