@extends('layouts.admin')

@section('title', 'Transaksi')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Transaksi</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Transaksi</h4>
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
                        <form action="{{ route('admin.transaction.store') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background-color: rgb(26, 85, 36);" class="btn btn-sm btn-primary">
                                Buat Transaksi <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </x-slot>

            <x-slot name="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>
                                    <a 
                                    href="{{ $transaction->status == 'Finished' 
                                        ? route('admin.transaction.finish.show', $transaction->id) 
                                        : route('admin.transaction.show', $transaction->id) }}" 
                                    class="d-inline-block text-decoration-none badge badge-primary"
                                    >
                                        {{ $transaction->reference_id }}
                                    </a>
                                </td>
                                <td>{{ $transaction->status }}</td>
                                <td>{{ $transaction->date->format('F j, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <p class="text-center"><em>There is no record.</em></p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </x-slot>

            <x-slot name="footer">
                {{ $transactions->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
