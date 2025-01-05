<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Transaction</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @forelse($transactions as $transaction)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $transaction->transaction->reference_id }}</td>
            <td>{{ $transaction->productStock->name }} / {{ $transaction->productStock->productList->type }} </td>
            <td>{{ $transaction->quantity }}</td>
            <td>
                {{ formatRupiah($transaction->total_amount) }}
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
        <td colspan="5" style="height: 20px;"></td> <!-- Empty row with a fixed height -->
    </tr>
    <tr>
        <td colspan="4"></td>
        <td>{{ 
            formatRupiah($transactions->sum(function ($transaction) 
            {
            return $transaction->total_amount;
            })) 
            }}
        </td>
    </tr>
    </tbody>
</table>
