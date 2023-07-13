<table class="table table-bordered  table-md">
    <thead>
    <tr>
        <th>No</th>
        <th>Reference Id</th>
        <th>Atas Nama</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @forelse($reservations as $reservation)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $reservation->reference_id }}</td>
            <td>{{ $reservation->name }}</td>
            <td>{{ $reservation->date->format('H:i - F j, Y ') }}</td>
            <td>
                <span>{{ $reservation->getStatus() }}</span>
            </td>
            <td>
                {{ formatRupiah($reservation->getSubtotalAttribute()) }}
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
        <td colspan="5"></td>
        <td>{{ 
            formatRupiah($reservations->sum(function ($reservation) 
            {
            return $reservation->getSubtotalAttribute();
            })) 
            }}
        </td>
    </tr>
    </tbody>
</table>
