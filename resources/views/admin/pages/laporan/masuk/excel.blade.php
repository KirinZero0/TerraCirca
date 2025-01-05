<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Tanggal</th>
        <th>Jumlah</th>
        <th>Harga</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $product->productList->name }}</td>
            <td>{{ $product->date->format('F j, Y') }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ formatRupiah($product->price) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <p class="text-center"><em>There is no record.</em></p>
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="5" style="height: 20px;"></td> <!-- Empty row with a fixed height -->
    </tr>
    <tr>
        <td colspan="3"></td>
        <td>{{ $products->sum('quantity') }}</td>
        <td>{{ formatRupiah($products->map(fn($product) => $product->price * $product->quantity)->sum()) }}</td>
    </tr>
    </tbody>
</table>
