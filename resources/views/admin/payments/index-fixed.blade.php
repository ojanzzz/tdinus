@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Kelola pembayaran dan konfirmasi member. Tombol konfirmasi/batalkan berfungsi full AJAX.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
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
                <tr>
                    <td><strong>{{ $payment->invoice_no }}</strong></td>
                    <td>{{ $payment->user->name }}<br><small>{{ $payment->user->email }}</small></td>
                    <td>{{ $payment->pelatihan->title }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>
                        @if($payment->bukti_path)
                            <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                        @if($payment->notes)
                            <br><small class="text-muted">{{ Str::limit($payment->notes, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if($payment->status === 'pending')
                            <button class="btn btn-sm btn-success confirm-paid" data-id="{{ $payment->id }}" data-name="{{ $payment->invoice_no }}">
                                <i class="fas fa-check me-1"></i> Konfirmasi Paid
                            </button>
                            <button class="btn btn-sm btn-danger reject-payment ms-1" data-id="{{ $payment->id }}" data-name="{{ $payment->invoice_no }}">
                                <i class="fas fa-times me-1"></i> Batalkan
                            </button>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <em>Belum ada pembayaran pending</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $payments->appends(request()->query())->links() }}
    </div>
</div>

{{-- Confirmation Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Invoice <strong id="confirm-invoice"></strong> akan diubah status menjadi <strong>PAID</strong>.</p>
                <div class="mb-3">
                    <label class="form-label">Catatan (opsional):</label>
                    <textarea class="form-control" id="confirm-notes" rows="3"></textarea>
                </div>
                <input type="hidden" id="confirm-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="do-confirm">
                    <i class="fas fa-check"></i> Konfirmasi PAID
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Batalkan Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Invoice <strong id="reject-invoice"></strong> akan dibatalkan.</p>
                <div class="mb-3">
                    <label class="form-label">Alasan (opsional):</label>
                    <textarea class="form-control" id="reject-notes" rows="3"></textarea>
                </div>
                <input type="hidden" id="reject-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="do-reject">
                    <i class="fas fa-times"></i> Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    'use strict';
    
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    
    // Konfirmasi
    document.querySelectorAll('.confirm-paid').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('confirm-id').value = this.dataset.id;
            document.getElementById('confirm-invoice').textContent = this.dataset.name;
            document.getElementById('confirm-notes').value = '';
            confirmModal.show();
        });
    });
    
    // Batalkan
    document.querySelectorAll('.reject-payment').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('reject-id').value = this.dataset.id;
            document.getElementById('reject-invoice').textContent = this.dataset.name;
            document.getElementById('reject-notes').value = '';
            rejectModal.show();
        });
    });
    
    // Do Confirm
    document.getElementById('do-confirm').addEventListener('click', async function() {
        const id = document.getElementById('confirm-id').value;
        const notes = document.getElementById('confirm-notes').value;
        
        const btn = document.querySelector(`.confirm-paid[data-id="${id}"]`);
        await processPayment(id, 'paid', notes, btn, 'Konfirmasi berhasil! Status: PAID');
        confirmModal.hide();
    });
    
    // Do Reject
    document.getElementById('do-reject').addEventListener('click', async function() {
        const id = document.getElementById('reject-id').value;
        const notes = document.getElementById('reject-notes').value;
        
        const btn = document.querySelector(`.reject-payment[data-id="${id}"]`);
        await processPayment(id, 'rejected', notes, btn, 'Pembayaran dibatalkan!');
        rejectModal.hide();
    });
    
    async function processPayment(id, status, notes, btn, successMsg) {
        btn.disabled = true;
        const original = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Processing...';
        
        try {
            const formData = new FormData();
            formData.append('status', status);
            formData.append('notes', notes);
            
            const response = await fetch(`/admin/payments/${id}/status`, {
                method: 'PATCH',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert(successMsg);
                // Update UI instantly
                const row = btn.closest('tr');
                const statusCell = row.cells[5];
                statusCell.innerHTML = `<span class="status-badge status-${status}">${status.toUpperCase()}</span>`;
                row.cells[7].innerHTML = `<span class="badge bg-success">✓ Selesai</span>`;
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('Error: ' + error.message + '\nCek console untuk detail.');
            console.error(error);
        } finally {
            btn.disabled = false;
            btn.innerHTML = original;
        }
    }
})();
</script>
@endpush

@endsection
