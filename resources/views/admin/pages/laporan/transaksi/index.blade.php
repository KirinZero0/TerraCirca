@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Laporan Transaksi</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Laporan Transaksi</h4>
                <div class="card-header-form row">
                    <div>
                        <form>
                            <div class="input-group">
                                <select type="text" name="month" id="month" class="form-control"
                                        onchange="this.form.submit()">
                                    <option value="">Pilih Bulan</option>
                                    @foreach($months as $key => $month)
                                        <option @if($key + 1 == request()->get('month')) selected
                                                @endif value="{{ $key + 1 }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="ml-2">
                        <a href="{{ route('admin.laporan.transaksi.export') }}" style="background-color: rgb(26, 85, 36)" class="btn btn-primary">
                            Export Data <i class="fas fa-download"></i>
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
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Subtotal</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->index + $transactions->firstItem() }}</td>
                                <td>{{ $transaction->reference_id }}</td>
                                <td>{{ $transaction->date->format('H:i - F j, Y ') }}</td>
                                <td>
                                    {{ formatRupiah($transaction->total_amount) }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{route('admin.transaction.invoice', $transaction->id)}}"><i class="fas fa-download"></i></a>
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
                {{ $transactions->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
