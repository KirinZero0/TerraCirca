@extends('layouts.admin')

@section('title', 'Tables')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

<x-content>
    <x-slot name="modul">
        <h1>Tables</h1>
    </x-slot>

    <x-section>
        <x-slot name="title">
        </x-slot>

        <x-slot name="header">
            <h4 style="color: black">Data Nomor Meja</h4>
            <div class="card-header-form row">
                <div class="ml-2">
                    <a href="{{ route('admin.table.create') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-sm btn-primary">
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
                            <th>Nomor Meja</th>
                            <th>Reference Id</th>
                            <th>Status</th>
                            <th>QR</th>

                            <th style="width:150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tables as $table)
                        <tr>
                            <td>{{ $table->table_number}}</td>
                            <td>{{ $table->reference_id }}</td>
                            <td>{{ $table->status }}</td>
                            <td>
                                <a href="{{ route('admin.table.download', $table->reference_id) }}"
                                    class="btn btn-icon btn-sm btn-success" data-toggle="tooltip">
                                    Download
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.table.destroy', $table->reference_id) }}" data-url="#"
                                    data-id="" data-redirect="#"
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
            {{ $tables->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
        </x-slot>
    </x-section>

</x-content>

@endsection
