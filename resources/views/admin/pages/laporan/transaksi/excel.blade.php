<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Reference Id</th>
        <th>Tanggal</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @forelse($transactions as $transaction)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $transaction->reference_id }}</td>
            <td>{{ $transaction->date->format('F j, Y') }}</td>
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
        <td colspan="4" style="height: 20px;"></td> <!-- Empty row with a fixed height -->
    </tr>
    <tr>
        <td colspan="3">Total</td>
        <td>{{ 
            formatRupiah($transactions->sum(function ($transaction) 
            {
            return $transaction->total_amount;
            })) 
            }}
        </td>
    </tr>
    <tr>
        <td colspan="3">Profit</td>
        <td>{{ 
            formatRupiah($transactions->sum(function ($transaction) 
            {
            return $transaction->profit_amount;
            })) 
            }}
        </td>
    </tr>
    </tbody>
</table>
