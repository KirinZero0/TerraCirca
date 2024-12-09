@extends('layouts.admin')

@section('title', 'Kelola Reservasi')

@section('css')

@endsection

@section('js')
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Kelola Reservasi</h1>
        </x-slot>

        <x-section>
            <x-slot name="title">
            </x-slot>

            <x-slot name="header">
                <h4>Data Reservasi</h4>
                <div class="card-header-form row">
                    <div>
                        <form>
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian"
                                    value="{{ Request::input('search') ?? ''}}">
                                <div class="input-group-btn">
                                    <button style="background-color: rgb(70, 147, 177)" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ml-2">
                        <a href="{{ route('admin.reservation.create') }}" style="background-color: rgb(70, 147, 177)" class="btn btn-sm btn-primary">
                            Tambah Data <i class="fas fa-plus"></i>
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
                            <th>Reference Id</th>
                            <th>Atas Nama</th>
                            <th>Nomor Meja</th>
                            <th>Jumlah Orang</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th style="width:150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $loop->index + $reservations->firstItem() }}</td>
                                <td>{{ $reservation->reference_id }}</td>
                                <td>{{ $reservation->name }}</td>
                                <td>{{ $reservation->table_number }}</td>
                                <td>{{ $reservation->number_of_people }}</td>
                                <td>{{ $reservation->date->format('H:i - F j, Y ') }}</td>
                                <td>
                                    <span class="{{ $reservation->getStatusColor() }}">{{ $reservation->getStatus() }}</span>
                                </td>
                                <td>
                                    @if($reservation->status == \App\Models\Reservation::PENDING)
                                        <a href="{{ route('admin.reservation.serve', $reservation->id) }}"
                                           class="btn btn-icon btn-sm btn-success" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Serve">
                                            <i class="fas fa-utensils"></i>
                                        </a>
                                        <a href="{{ route('admin.reservation.cancel', $reservation->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="Cancel" data-original-title="Cancel"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-exclamation"></i>
                                        </a>
                                    @elseif($reservation->status == \App\Models\Reservation::PROGRESS)
                                        <a href="{{ route('admin.reservation.serve', $reservation->id) }}"
                                            class="btn btn-icon btn-sm btn-success" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Serve">
                                            <i class="fas fa-utensils"></i>
                                        </a>
                                        <a href="{{ route('admin.reservation.finish', $reservation->id)}}"
                                           class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Finish">
                                            <i class="far fa-thumbs-up"></i>
                                        </a>
                                        <a href="{{ route('admin.reservation.cancel', $reservation->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="Cancel" data-original-title="Cancel"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-exclamation"></i>
                                        </a>
                                    @elseif($reservation->status == \App\Models\Reservation::FINISH)
                                        <a href="{{ route('admin.reservation.view', $reservation->id) }}" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="View"
                                           class="btn btn-sm btn-primary ">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.reservation.destroy', $reservation->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Delete"
                                            class="btn btn-sm btn-danger">
                                             <i class="fas fa-trash"></i>
                                         </a>
                                    @elseif($reservation->status == \App\Models\Reservation::CANCEL)
                                        <a href="{{ route('admin.reservation.destroy', $reservation->id) }}" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Delete"
                                           class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @elseif($reservation->status == \App\Models\Reservation::ORDER)
                                        <a href="{{ route('admin.reservation.destroy', $reservation->id) }}" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Delete"
                                           class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                    
                                </td>
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
                {{ $reservations->onEachSide(2)->appends($_GET)->links('admin.partials.pagination') }}
            </x-slot>
        </x-section>

    </x-content>

@endsection
