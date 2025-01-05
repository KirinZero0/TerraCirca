<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Barcode</th>
        <th>Nama Produk</th>
        <th>Tanggal Keluar/Retur</th>
        <th>Tipe</th>
        <th>Jumlah</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $product->productStock->barcode }}</td>
            <td>{{ $product->productStock->name }}</td>
            <td>{{ $product->date->format('F j, Y') }}</td>
            <td>{{ $product->type }}</td>
            <td>{{ $product->quantity }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <p class="text-center"><em>There is no record.</em></p>
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="6" style="height: 20px;"></td> <!-- Empty row with a fixed height -->
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>{{ $products->sum('quantity') }}</td>
    </tr>
    </tbody>
</table>
