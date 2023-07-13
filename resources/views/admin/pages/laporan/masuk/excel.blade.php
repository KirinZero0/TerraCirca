<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $product->product['custom_id'] }}</td>
            <td>{{ $product->product['name'] }}</td>
            <td>{{ formatRupiah($product->price) }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->date->format('F j, Y') }}</td>
            <td>
                <span>{{ $product->getStatus() }}@if(!blank($product->reasons)){{ ': ' . $product->reasons }} @endif</span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <p class="text-center"><em>There is no record.</em></p>
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="3"></td>
        <td>{{ formatRupiah($products->sum('price')) }}</td>
        <td>{{ $products->sum('quantity') }}</td>
    </tr>
    </tbody>
</table>
