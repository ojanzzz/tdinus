@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">📚 Pelatihan</h1>
        <p class="page-subtitle">Ambil pelatihan, lanjutkan pembayaran, dan pantau pelatihan aktif Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Kembali</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">⚠️ {{ session('error') }}</div>
@endif

@if($activePelatihans->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">▶️ Pelatihan Aktif Saya</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Pelatihan yang sudah diterima admin dan sedang berjalan.</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
            @foreach($activePelatihans as $item)
                @php
                    $payment = $latestPayments->get($item->pelatihan_id);
                @endphp
                <div style="background: var(--light-color); border-radius: 0.75rem; padding: 1.25rem; border-left: 4px solid var(--primary-color);">
                    <h3 style="margin: 0 0 0.5rem 0; color: var(--dark-color);">{{ Str::limit($item->pelatihan->title ?? '-', 45) }}</h3>
                    <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.9rem;">
                        Aktif sejak {{ optional($item->issue_date)->format('d M Y') ?? optional($item->created_at)->format('d M Y') }}
                    </p>
                    @if($payment)
                        <a href="{{ route('member.payments.show', $payment) }}" class="btn-outline" style="display: inline-block; padding: 0.6rem 1rem;">
                            Lihat Pembayaran
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($available->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">🎓 Pelatihan Tersedia</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Klik "Ambil Pelatihan" untuk membuat invoice dan masuk ke menu pembayaran.</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($available as $p)
                @php
                    $latestPayment = $latestPayments->get($p->id);
                    $isActive = in_array($p->id, $activePelatihanIds, true);
                    $isIssued = in_array($p->id, $issuedPelatihanIds, true);
                @endphp
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border-left: 4px solid var(--primary-color);">
                    @if($p->image_path)
                        <img src="{{ $p->image_path }}" alt="{{ $p->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: white;">
                            📚 {{ substr($p->title, 0, 1) }}
                        </div>
                    @endif

                    <div style="padding: 1.5rem;">
                        <h3 style="margin: 0 0 0.75rem 0; font-size: 1.1rem; color: var(--dark-color);">{{ Str::limit($p->title, 35) }}</h3>
                        <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.9rem; line-height: 1.5;">{{ Str::limit(strip_tags($p->description), 80) }}</p>

                        <div style="display: flex; gap: 1rem; margin: 1rem 0; padding: 1rem 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
                            @if($p->duration)
                                <div style="flex: 1; text-align: center;">
                                    <small style="color: #999;">Durasi</small>
                                    <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: var(--primary-color);">{{ $p->duration }}</p>
                                </div>
                            @endif
                            <div style="flex: 1; text-align: center;">
                                <small style="color: #999;">Harga</small>
                                <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: var(--primary-color);">
                                    @if($p->price > 0)
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($isIssued)
                            <a href="{{ route('member.sertifikat.index') }}" class="btn-outline" style="display: block; width: 100%; text-align: center; padding: 0.75rem;">
                                ✓ Sertifikat Tersedia
                            </a>
                        @elseif($isActive || optional($latestPayment)->status === 'paid')
                            @if($latestPayment)
                                <a href="{{ route('member.payments.show', $latestPayment) }}" class="btn-outline" style="display: block; width: 100%; text-align: center; padding: 0.75rem;">
                                    ✓ Pelatihan Aktif
                                </a>
                            @else
                                <span class="btn-outline" style="display: block; width: 100%; text-align: center; padding: 0.75rem; opacity: 0.75;">
                                    ✓ Pelatihan Aktif
                                </span>
                            @endif
                        @elseif(optional($latestPayment)->status === 'pending')
                            <a href="{{ route('member.payments.show', $latestPayment) }}" class="btn-primary" style="display: block; width: 100%; text-align: center; padding: 0.75rem;">
                                Ke Menu Pembayaran
                            </a>
                        @else
                            <form method="POST" action="{{ route('member.pelatihan.take', $p) }}" style="display: block; width: 100%;">
                                @csrf
                                <button type="submit" class="btn-primary" style="width: 100%; text-align: center; padding: 0.75rem;">
                                    {{ optional($latestPayment)->status === 'rejected' ? 'Ambil Ulang Pelatihan' : 'Ambil Pelatihan' }}
                                </button>
                            </form>
                            @if(optional($latestPayment)->status === 'rejected')
                                <p style="margin: 0.75rem 0 0 0; color: #dc3545; font-size: 0.85rem;">Pembayaran sebelumnya ditolak. Anda bisa mengajukan ulang.</p>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="member-card" style="text-align: center; padding: 3rem 1.5rem;">
        <p style="font-size: 1.2rem; color: #999; margin: 0;">📚 Tidak ada pelatihan aktif saat ini.</p>
        <p style="color: #999; margin-top: 0.5rem;">Silakan cek kembali nanti atau hubungi admin.</p>
    </div>
@endif

@if($payments->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">💳 Riwayat Pendaftaran & Pembayaran</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Daftar pelatihan yang pernah Anda ambil beserta status pembayarannya.</p>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pelatihan</th>
                        <th>Tanggal Ambil</th>
                        <th>Status Pembayaran</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td><strong>{{ Str::limit($payment->pelatihan->title ?? '-', 40) }}</strong></td>
                            <td><small>{{ $payment->created_at->format('d M Y H:i') }}</small></td>
                            <td>
                                <span class="status-badge status-{{ strtolower($payment->status) }}">
                                    @if($payment->status === 'pending')
                                        ⏳ Menunggu Review
                                    @elseif($payment->status === 'paid')
                                        ✓ Diterima / Aktif
                                    @elseif($payment->status === 'rejected')
                                        ❌ Ditolak
                                    @else
                                        {{ ucfirst($payment->status) }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ $payment->notes ? Str::limit($payment->notes, 50) : '-' }}</td>
                            <td>
                                @if($payment->status === 'rejected')
                                    <form method="POST" action="{{ route('member.pelatihan.take', $payment->pelatihan) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Ambil Ulang</button>
                                    </form>
                                @else
                                    <a href="{{ route('member.payments.show', $payment) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Lihat Pembayaran</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
