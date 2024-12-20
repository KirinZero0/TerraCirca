@extends('layouts.admin')

@section('title', 'Pasien')

@section('css')

@endsection

@section('js')

@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.patient.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Pasien
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pasien</h4>
                            <a href="{{ route('admin.patient.edit', $patient->id) }}"
                                class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                 <i class="far fa-edit"></i>
                             </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$patient->name}} <span class="badge badge-secondary">{{$patient->id}}</span></h5>
                            <p class="card-text">Alamat: {{$patient->address}}</p>
                            <p class="card-text">No Tlp: {{$patient->phone}}</p>
                            <p class="card-title">
                                @if($latestCheckup)
                                    Checkup Terakhir: {{ $latestCheckup->date->format('F j, Y') }}
                                @else
                                    Pasien belum pernah checkup atau tidak ada data checkup
                                @endif
                            </p>
                            </p>  
                        </div>
                        <a href="{{ route('admin.patient.destroy', $patient->id) }}" data-toggle="tooltip"
                            data-placement="top" title="" data-original-title="Delete"
                            class="btn btn-sm btn-danger delete">
                             <i class="fas fa-trash"></i>
                         </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data</h4>
                            <div>
                                <form>
                                    <div class="input-group">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian"
                                            value="{{ Request::input('search') ?? ''}}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                            
                        <div class="card-body">
                            <div class="table-responsive">
                                <h5 class="mb-3">Transaksi dan Checkup</h5>
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                    <td>
                                                        <a href="{{ route('admin.transaction.show', $transaction->id) }}" 
                                                            class="d-inline-block text-decoration-none badge badge-primary">
                                                            {{ $transaction->reference_id }}
                                                        </a>
                                                    </td>
                                                    <td style="width: 30%">{{ formatRupiah($transaction->total_amount) }}</td>
                                                    <td style="width: 30%">{{ $transaction->date->format('F j, Y') }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content>


@endsection

