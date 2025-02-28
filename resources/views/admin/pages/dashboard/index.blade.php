@extends('layouts.admin')

@section('title', 'Dashboard')

@section('css')

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');

    // Pass PHP arrays to JavaScript
    const labels = @json($dates);
    const productInData = @json($productInCount);
    const productOutData = @json($productOutCount);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pemasukan',
                data: productInData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Pengeluaran',
                data: productOutData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>
@endsection

@section('content')

    <x-content>
        <x-slot name="modul">
            <h1>Dashboard</h1>
        </x-slot>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pasien</h4>
                            </div>
                            <div class="card-body">
                                {{$patients}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                {{ formatRupiah($costs) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pemasukan</h4>
                            </div>
                            <div class="card-body">
                                {{ formatRupiah($revenues) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Produk Tersedia</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalProducts }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-size-monitor"
                                 style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="myChart" height="840" style="display: block; height: 420px; width: 693px;"
                                    width="1386" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Produk Kadaluarsa / Hampir Kadaluarsa</h4>
                            <div class="badge badge-pendings text-capitalize">{{ $expireds }}</div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach($products as $product)
                                <li class="media">
                                    <div class="media-body">
                                        <div
                                            class="float-right text-primary">
                                            <span>
                                                @if($product->status == 'Expired')
                                                <i class="fa fa-exclamation text-danger" title="Expired"></i>
                                            @elseif($product->status == 'Near Expired')
                                                <i class="fa fa-exclamation text-warning" title="Near Expired"></i>
                                            @endif
                                            </span>
                                        </div>
                                        <div class="media-title">
                                            <a href="{{ route('admin.product.product_stock.show', $product->id) }}">
                                                {{$product->barcode}}-{{ $product->name }}
                                            </a>
                                        </div>
                                        <span class="text-small text-muted">{{ $product->stock }}</span>
                                        <br>
                                        <div
                                        style="background-color: rgb(26, 85, 36)" class="badge badge-success text-capitalize">{{ $product->quantity }}</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="text-center pt-1 pb-1">
                                <a href="{{ route('admin.product.product_stock.index') }}"
                                style="background-color: rgb(26, 85, 36)" class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content>

@endsection
