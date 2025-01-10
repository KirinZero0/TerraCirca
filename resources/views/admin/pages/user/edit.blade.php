@extends('layouts.admin')

@section('title', 'Edit User')

@section('css')

@endsection

@section('js')

@endsection

@section('content')
    <x-content>
        <x-slot name="modul">
            @include('admin.partials.back-with-title', ['title' => 'Edit User'])
        </x-slot>
        <div>
            <form action="{{ route('admin.admin.update', $user->id) }}" enctype="multipart/form-data" method="post"
                  class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12 col-sm-12 my-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Dasar</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-title mt-0">Informasi Dasar</div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name) }}"
                                           required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" id="username" class="form-control" name="username" value="{{ old('username', $user->username) }}"
                                           required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" name="email"
                                           value="{{ old('email', $user->email) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="{{ \App\Enums\AdminRoleEnum::ADMIN }}" 
                                        {{ $user->role == \App\Enums\AdminRoleEnum::ADMIN ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="{{ \App\Enums\AdminRoleEnum::CASHIER }}" 
                                        {{ $user->role == \App\Enums\AdminRoleEnum::CASHIER ? 'selected' : '' }}>
                                        Kasir
                                    </option>
                                    <option value="{{ \App\Enums\AdminRoleEnum::STAFF }}" 
                                        {{ $user->role == \App\Enums\AdminRoleEnum::STAFF ? 'selected' : '' }}>
                                        Staff
                                    </option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control" name="password"
                                                   tabindex="2" required>
                                            <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer">
                                                <i class="fas fa-eye-slash" id="togglePassword"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="d-block">
                                            <label for="passwordConfirmation" class="control-label">Konfirmasi Password</label>
                                        </div>
                                        <div class="input-group">
                                            <input id="passwordConfirmation" type="password" class="form-control" name="password_confirmation"
                                                   tabindex="2" required>
                                            <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer">
                                                <i class="fas fa-eye-slash" id="togglePasswordConfirmation"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
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
