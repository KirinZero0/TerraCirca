@extends('layouts.admin')

@section('title', 'Transaksi')

@section('css')

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#patientDropdown').select2({
            placeholder: 'Pilih Pasien',
            allowClear: true,
            width: '100%',
            matcher: function(params, data) {
                // Match patient name or phone
                var nameOrPhone = data.text.toLowerCase();
                var searchTerm = params.term.toLowerCase();
                if (nameOrPhone.indexOf(searchTerm) !== -1) {
                    return data;
                }
                return null;
            }
        });
    });
</script>
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>
                <a href="{{ route('admin.transaction.index') }} " style="color: #404040;" class="text-decoration-none mr-2">
                    <i class="fas fa-arrow-left" style="font-size: 21px;"></i>
                </a>
                Transaksi
            </h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$transaction->reference_id}}</h5>
                            <p class="card-text">{{$transaction->date->format('F j, Y')}}</p>
                            <!-- Patient Selection -->
                            <div class="d-flex align-items-center mb-3">
                                @if($transaction->patient)
                                    <p class="card-text mb-0">{{ $transaction->patient->name. ' - ' . $transaction->patient->phone }}</p>
                                @else
                                    <!-- Patient Dropdown -->
                                    <form action="{{ route('admin.transaction.update', $transaction->id) }}" method="post" class="w-100">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group w-100">
                                            <label for="patientDropdown" class="sr-only">Pilih Pasien</label>
                                            <select name="patient_id" id="patientDropdown" class="form-control" required>
                                                <option value="">Pilih Pasien</option>
                                                @foreach($patients as $patient)
                                                    <option value="{{ $patient->id }}" data-phone="{{ $patient->phone }}">
                                                        {{ $patient->name }} - {{ $patient->phone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary">Tambah Pasien</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <h5 class="card-title">Item:</h5>
                            @forelse($transactionItems as $item)
                            <p class="card-text d-flex align-items-center justify-content-between">
                                {{$item->productStock->name}}
                                <span class="ml-2 mr-2"> x{{$item->quantity}}</span> 
                                <span class="mr-2">{{ formatRupiah($item->total_amount) }}</span>
                                <span>                                
                                    @if($item->productStock->status == 'Expired')
                                    <i class="fa fa-exclamation text-danger" title="Expired"></i>
                                    @elseif($item->productStock->status == 'Near Expired')
                                        <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                                    @endif
                                </span>
                                <a class="btn btn-sm btn-danger ml-auto" href="{{ route('admin.transaction.transaction-item.destroy', $item->id)}}"><i class="fas fa-trash"></i></a>
                            </p>     
                            @empty
                            <p class="card-text">Item Kosong</p>
                            @endforelse
                                <h5 class="card-title">Subtotal: 
                                    <strong>
                                    {{formatRupiah($transaction->total_amount)}}
                                    </strong>  
                                </h5>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input id="moneyInput" type="text" class="form-control" placeholder="Input Amount" aria-label="Input Amount" aria-describedby="basic-addon1">
                                </div>
                                <h5 class="card-title" id="change"> Kembalian: </h5>
                            {{-- <a id="printInvoiceBtn" class="btn btn-success" href="{{route('admin.cashier.invoice2', $reservation->id)}}">Print Invoice</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Menu</h4>
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
                                <h5 class="mb-3">Produk</h5>
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        @forelse($productStocks as $productStock)
                                            <tr>
                                                <form action="{{ route('admin.transaction.transaction-item.store', ['transaction' => $transaction->id]) }}" enctype="multipart/form-data" method="post"
                                                class="needs-validation" novalidate onkeydown="return event.key !== 'Enter';">
                                                @csrf
                                                    <input type="hidden" name="product_stock_id" value="{{ $productStock->id }}">
                                                    <td style="width: 20%">
                                                        @if($productStock->status == 'Expired')
                                                        <i class="fa fa-exclamation text-danger" title="Expired"></i>
                                                    @elseif($productStock->status == 'Near Expired')
                                                        <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                                                    @endif
                                                        {{ $productStock->barcode }}</td>
                                                    <td style="width: 30%">{{ $productStock->name }}</td>
                                                    <td style="width: 30%">{{ formatRupiah($productStock->selling_price) }}</td>
                                                    <td style="width: 10%">
                                                        <input type="input" class="form-control" name="quantity" min="0" required>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <button type="submit" class="btn btn-success">Tambah</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <p class="text-center"><em>There are no records.</em></p>
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
    <script>
        const moneyInput = document.getElementById('moneyInput');
        const inputText = document.getElementById('inputText');
        const change = document.getElementById('change');
        
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
        }

        moneyInput.addEventListener('input', () => {
            const enteredAmount = parseFloat(moneyInput.value) || 0;
            
            const subtotal = {{ $transaction->total_amount }};
            
            const diff = enteredAmount - subtotal;
            change.textContent = `Kembalian: ${formatRupiah(diff)}`;
        });


    </script>

@endsection

