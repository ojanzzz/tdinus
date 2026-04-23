@extends('layouts.app') 
@section('content')

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header Pelatihan -->
            <h1 class="card-title">{{ $pelatihan->title }}</h1>
            <p class="text-muted">{{ $pelatihan->description }}</p>
            
            <hr>

            <!-- Informasi Harga -->
            <div class="price-info mb-4">
                <h5>Harga Pelatihan</h5>
                @if($pelatihan->price > 0)
                    <p class="fs-4 text-primary fw-bold">Rp {{ number_format($pelatihan->price, 0, ',', '.') }}</p>
                @else
                    <p class="fs-4 text-success fw-bold">GRATIS</p>
                @endif
            </div>

            <!-- Bagian Tombol Aksi -->
            <div class="action-area mt-4">
                @if($pelatihan->is_taken)
                    <!-- KONDISI 1: SUDAH MENGAMBIL PELATIHAN -->
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <div>
                            <strong>Berhasil!</strong> Pelatihan ini sudah Anda ambil.
                        </div>
                    </div>

                @elseif(auth()->check())
                    <!-- KONDISI 2: USER SUDAH LOGIN - TOMBOL AJAX AMBIL -->
                    <button id="ambil-pelatihan-btn" class="btn btn-primary btn-lg" data-pelatihan-id="{{ $pelatihan->id }}">
                        Ambil Pelatihan Ini
                    </button>

                @else
                    <!-- KONDISI 3: USER BELUM LOGIN -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                            <path d="m8.93.456-6.3 3.95A1 1 0 0 0 2 4.736v6.528a1 1 0 0 0 .63.93l6.3 3.95a1 1 0 0 0 1.04 0l6.3-3.95a1 1 0 0 0 .63-.93V4.736a1 1 0 0 0-.63-.93l-6.3-3.95A1 1 0 0 0 8.93.456z"/>
                        </svg>
                        <div>
                            <strong>Silakan login</strong> untuk mengambil pelatihan ini.
                            <a href="{{ route('login.member') }}" class="btn btn-sm btn-primary ms-2">Login Sekarang</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Ambil Pelatihan Modal -->
    <div class="modal fade" id="pelatihanModal" tabindex="-1" aria-labelledby="pelatihanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pelatihanModalLabel">Pelatihan Berhasil Diambil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    <!-- Dynamic content here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-action-link" class="btn btn-primary" style="display: none;">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('ambil-pelatihan-btn');
    const modal = new bootstrap.Modal(document.getElementById('pelatihanModal'));

    if (btn) {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            // Loading state
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';

            try {
                const response = await fetch(`/member/pelatihan/${this.dataset.pelatihanId}/take`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || document.querySelector('[name=csrf-token]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Success modal
                    document.getElementById('pelatihanModalLabel').textContent = '✅ Berhasil!';
                    document.getElementById('modal-body').innerHTML = `
                        <div class="alert alert-success">
                            <strong>${data.message || 'Pelatihan berhasil diambil!'}</strong>
                            <br>Tunggu konfirmasi dari admin.
                        </div>
                    `;
                    
                    if (data.redirect || data.payment_id) {
                        document.getElementById('modal-action-link').href = data.redirect || `/member/payments/${data.payment_id}`;
                        document.getElementById('modal-action-link').textContent = 'Lihat Pembayaran';
                        document.getElementById('modal-action-link').style.display = 'inline-block';
                    }
                    
                    // Reload page after modal close to update is_taken status
                    document.getElementById('pelatihanModal').addEventListener('hidden.bs.modal', function () {
                        location.reload();
                    }, { once: true });
                    
                    modal.show();
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                // Error handling
                const errorMsg = error.message || 'Gagal mengambil pelatihan. Pastikan Anda sudah login dan pelatihan tersedia.';
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.innerHTML = `<strong>Error:</strong> ${errorMsg}`;
                btn.parentNode.insertBefore(alertDiv, btn.nextSibling);
                setTimeout(() => alertDiv.remove(), 5000);
            } finally {
                // Reset button
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    }
});
</script>
@endpush

@endsection
