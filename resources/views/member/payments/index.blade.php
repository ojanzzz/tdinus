@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Daftar invoice pembayaran pelatihan Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Dashboard</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="form-error">{{ session('error') }}</div>
@endif

@if($payments->isNotEmpty())
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Pelatihan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->invoice_no }}</strong></td>
                        <td>{{ $payment->pelatihan->title }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($payment->status) }}">
                                {{ $payment->status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($payment->status) }}
                            </span>
                            @if($payment->bukti_path)
                                <br><a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn-outline small">Lihat Bukti</a>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        <td class="table-actions">
                            <a href="{{ route('member.payments.show', $payment) }}" class="btn-primary">Lihat Invoice</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
@else
    <div class="admin-main-empty">
        <p>Belum ada pembayaran pelatihan.</p>
        <a href="{{ route('member.pelatihan.index') }}" class="btn-primary">Lihat Pelatihan</a>
    </div>
@endif
@endsection

