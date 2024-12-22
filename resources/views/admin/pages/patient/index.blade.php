@extends('layouts.admin')

@section('title', 'Kelola List Pasien')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kelola List Pasien</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data List Pasien</h4>
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
                        <a href="{{ route('admin.patient.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
                            Tambah Pasien <i class="fas fa-plus"></i>
                        </a>
                    </div>

                </div>
            </x-slot>

            <x-slot name="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor Telp</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td>{{ $loop->index + $patients->firstItem() }}</td>
                                <td>
                                    <a href="{{ route('admin.patient.show', $patient->id) }}" 
                                        class="d-inline-block text-decoration-none badge badge-primary">
                                        {{ $patient->name }}
                                    </a>
                                </td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <p class="text-center"><em>There are no record.</em></p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </x-slot>

            <x-slot name="footer">
                {{ $patients->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
