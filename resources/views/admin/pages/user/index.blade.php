@extends('layouts.admin')

@section('title', 'User')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

<x-content>
    <x-slot name="modul">
        <h1>User</h1>
    </x-slot>

    <x-section>
        <x-slot name="title">
        </x-slot>

        <x-slot name="header">
            <h4>Data Users</h4>
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
                    <a href="{{ route('admin.user.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                        Tambah Data <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive">
                <table class="table table-bordered  table-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th style="width:150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->index + $users->firstItem() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Edit">
                                    <i class="far fa-edit"></i>
                                </a>

                                <a href="{{ route('admin.user.destroy', $user->id) }}" data-url="#"
                                    data-id="{{ $user->id }}" data-redirect="#"
                                    class="btn btn-sm btn-danger delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <p class="text-center"><em>There is no record.</em></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            {{ $users->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
        </x-slot>
    </x-section>

</x-content>

@endsection
