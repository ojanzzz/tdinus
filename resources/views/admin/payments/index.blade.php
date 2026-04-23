@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Review bukti pembayaran member, lalu terima untuk mengaktifkan pelatihan atau tolak agar member bisa mengajukan ulang.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">{{ session('error') }}</div>
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
                            <a href="{{ route('admin.payments.bukti', $payment) }}" target="_blank" class="btn btn-sm btn-outline-primary">Bukti</a>
                        @else
                            -
                        @endif
                    </td>
                    <td id="status-{{ $payment->id }}">
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            @if($payment->status === 'pending')
                                Menunggu Review
                            @elseif($payment->status === 'paid')
                                Diterima / Aktif
                            @elseif($payment->status === 'rejected')
                                Ditolak
                            @else
                                {{ ucfirst($payment->status) }}
                            @endif
                        </span>
                        @if($payment->notes)
                            <br><small>{{ Str::limit($payment->notes, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if($payment->status === 'pending')
                            <button onclick="confirmPayment({{ $payment->id }}, '{{ $payment->invoice_no }}')" class="btn btn-sm btn-success">
                                ✅ Terima Pembayaran
                            </button>
                            <button onclick="rejectPayment({{ $payment->id }}, '{{ $payment->invoice_no }}')" class="btn btn-sm btn-danger ms-1">
                                ❌ Tolak
                            </button>
                        @else
                            <span class="badge {{ $payment->status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $payment->status === 'paid' ? 'Aktif' : 'Ditolak' }}
                            </span>
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
    if (!confirm(`Terima pembayaran invoice ${invoice} dan aktifkan pelatihan?`)) return;
    
    fetch(`/admin/payments/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'paid', notes: 'Pembayaran diterima admin.' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('row-' + id);
            const statusCell = document.getElementById('status-' + id);
            statusCell.innerHTML = '<span class="status-badge status-paid">DITERIMA / AKTIF</span>';
            row.cells[7].innerHTML = '<span class="badge bg-success">✓ Aktif</span>';
            alert('Pembayaran diterima. Pelatihan member sudah aktif.');
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
    const notes = prompt(`Alasan penolakan invoice ${invoice}? (opsional)`);
    if (!confirm(`Tolak pembayaran ${invoice}? Member dapat mengajukan ulang.`)) return;
    
    fetch(`/admin/payments/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'rejected', notes: notes || 'Pembayaran ditolak admin.' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('row-' + id);
            const statusCell = document.getElementById('status-' + id);
            statusCell.innerHTML = '<span class="status-badge status-rejected">DITOLAK</span>';
            row.cells[7].innerHTML = '<span class="badge bg-danger">Ditolak</span>';
            alert('Pembayaran ditolak. Member dapat mengambil ulang pelatihan.');
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
