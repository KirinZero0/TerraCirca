<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $product->productList->name }}</td>
            <td>{{ formatRupiah($product->price) }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->date->format('F j, Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <p class="text-center"><em>There is no record.</em></p>
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="2"></td>
        <td>{{ formatRupiah($products->map(fn($product) => $product->price * $product->quantity)->sum()) }}</td>
        <td>{{ $products->sum('quantity') }}</td>
    </tr>
    </tbody>
</table>
