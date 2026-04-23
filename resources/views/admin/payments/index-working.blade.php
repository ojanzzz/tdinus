@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Kelola pembayaran - klik tombol untuk konfirmasi PAID atau batalkan.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Member</th>
                <th>Pelatihan</th>
                <th>Jumlah</th>
                <th>Bukti</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr id="row-{{ $payment->id }}">
                    <td><strong>{{ $payment->invoice_no }}</strong></td>
                    <td>{{ $payment->user->name }}<br><small>{{ $payment->user->email }}</small></td>
                    <td>{{ $payment->pelatihan->title }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>
                        @if($payment->bukti_path)
                            <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Bukti</a>
                        @else
                            -
                        @endif
                    </td>
                    <td id="status-{{ $payment->id }}">
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                        @if($payment->notes)
                            <br><small>{{ Str::limit($payment->notes, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if($payment->status === 'pending')
                            <button onclick="confirmPayment({{ $payment->id }}, '{{ $payment->invoice_no }}')" class="btn btn-sm btn-success">
                                ✅ Konfirmasi Paid
                            </button>
                            <button onclick="rejectPayment({{ $payment->id }}, '{{ $payment->invoice_no }}')" class="btn btn-sm btn-danger ms-1">
                                ❌ Batalkan
                            </button>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $payments->links() }}
</div>

<script>
function confirmPayment(id, invoice) {
    if (!confirm(`Konfirmasi pembayaran invoice ${invoice} menjadi PAID?`)) return;
    
    fetch(`/admin/payments/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'paid', notes: 'Dikonfirmasi via tombol' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('row-' + id);
            const statusCell = document.getElementById('status-' + id);
            statusCell.innerHTML = '<span class="status-badge status-paid">PAID</span>';
            row.cells[7].innerHTML = '<span class="badge bg-success">✓ Selesai</span>';
            alert('Status diubah ke PAID! Sertifikat dibuat untuk member.');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        alert('Error: ' + err);
        console.error(err);
    });
}

function rejectPayment(id, invoice) {
    const notes = prompt(`Alasan batalkan invoice ${invoice}? (opsional)`);
    if (!confirm(`Batalkan pembayaran ${invoice}?`)) return;
    
    fetch(`/admin/payments/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'rejected', notes: notes || 'Dibatalkan admin' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('row-' + id);
            const statusCell = document.getElementById('status-' + id);
            statusCell.innerHTML = '<span class="status-badge status-rejected">REJECTED</span>';
            row.cells[7].innerHTML = '<span class="badge bg-danger">Dibatalkan</span>';
            alert('Status dibatalkan!');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        alert('Error: ' + err);
        console.error(err);
    });
}
</script>

<style>
.status-badge { padding: .25rem .5rem; border-radius: .25rem; font-size: .875rem; font-weight: 500; }
.status-pending { background: #fff3cd; color: #856404; }
.status-paid { background: #d4edda; color: #155724; }
.status-rejected { background: #f8d7da; color: #721c24; }
.btn-sm { font-size: .8rem; padding: .25rem .5rem; }
</style>
@endsection

