@extends('layouts.app') 
@section('content')

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header Pelatihan -->
            <h1 class="card-title">{{ $pelatihan->judul }}</h1>
            <p class="text-muted">{{ $pelatihan->deskripsi }}</p>
            
            <hr>

            <!-- Bagian Tombol Aksi -->
            <div class="action-area mt-4">
                @if($sudahDiambil)
                    <!-- KONDISI 1: SUDAH MENGAMBIL PELATIHAN -->
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <div>
                            <strong>Berhasil!</strong> Pelatihan ini sudah Anda ambil.
                        </div>
                    </div>

                @else
                    <!-- KONDISI 2: BELUM MENGAMBIL (TAMPILKAN TOMBOL) -->
                    <button type="button" class="btn btn-primary btn-lg" id="btnBeliPelatihan">
                        Ambil Pelatihan Ini
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- MODAL PEMBAYARAN INVOICE -->
<!-- Modal ini hanya dirender secara HTML, tapi disembunyikan via CSS/JS jika diperlukan -->
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembayaranLabel">Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan melakukan pembayaran untuk pelatihan:</p>
                <h4>{{ $pelatihan->judul }}</h4>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Total Tagihan:</span>
                    <span class="fw-bold fs-5 text-primary">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</span>
                </div>
                
                <!-- Form untuk memproses pembayaran (misal ke Payment Gateway) -->
                <form action="{{ route('pelatihan.proses-pembayaran', $pelatihan->id) }}" method="POST" id="formPembayaran">
                    @csrf
                    <!-- Input tersembunyi jika diperlukan -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <!-- Tombol ini akan submit form di atas -->
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formPembayaran').submit()">
                    Lanjut Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Modal Bootstrap (Pastikan Anda sudah load JS Bootstrap)
        var myModal = new bootstrap.Modal(document.getElementById('modalPembayaran'));

        // Event Listener untuk tombol "Ambil Pelatihan Ini"
        var btnBeli = document.getElementById('btnBeliPelatihan');
        if(btnBeli) {
            btnBeli.addEventListener('click', function() {
                // Tampilkan Modal Pembayaran
                myModal.show();
            });
        }
    });
</script>

@endsection
