@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img width="180" src="{{ asset('assets/images/logo/Clinic.png') }}" alt="">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.login') }}" class="needs-validation"
                                  novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ old('username') }}" tabindex="1" required autofocus>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group">
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

                                <div class="form-group">
                                    <button type="submit" style="background-color: rgb(70, 147, 177)" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
