@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Kelola pembayaran dan konfirmasi member (member, status, konfirmasi pembayaran).</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Invoice No</th>
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
                <tr>
                    <td><strong>{{ $payment->invoice_no }}</strong></td>
                    <td>{{ $payment->user->name }}<br><small>{{ $payment->user->email }}</small></td>
                    <td>{{ $payment->pelatihan->title }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>
                        @if($payment->bukti_path)
                            <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn-outline small">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                        @if($payment->notes)
                            <br><small>{{ Str::limit($payment->notes, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td class="table-actions">
                        @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-input" style="width: auto; font-size: 12px;">
                                    <option value="paid">Konfirmasi Bayar</option>
                                    <option value="rejected">Tolak</option>
                                </select>
                                <textarea name="notes" placeholder="Catatan konfirmasi" style="width: 150px; height: 50px; font-size: 12px; margin-top: 5px;"></textarea>
                                <button type="submit" class="btn-primary small" onclick="return confirm('Update status?')">Update</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $payments->links() }}
</div>

<a href="{{ route('admin.members.index') }}" class="btn-outline" style="margin-top: 1rem; display: inline-block;">← Kelola Member</a>

<style>
    .small { font-size: 0.8rem; padding: 0.25rem 0.5rem !important; }
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-paid { background-color: #d4edda; color: #155724; }
    .status-rejected { background-color: #f8d7da; color: #721c24; }
</style>
@endsection

