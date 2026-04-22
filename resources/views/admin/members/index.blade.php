@extends('layouts.admin')

@section('admin-content')
    <div class="admin-header">
        <div>
            <h1 class="page-title">👥 Member</h1>
            <p class="page-subtitle">Kelola akun member dan pelatihan.</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn-primary">+ Tambah Member</a>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    <!-- Tab Navigation -->
    <div class="member-card" style="display: flex; gap: 1rem; padding: 1rem; border-bottom: 2px solid var(--border-color); border-radius: 0;">
        <button id="show-members" class="btn-primary" style="border-radius: 0.5rem 0.5rem 0 0; flex: 1;">📋 Data Member</button>
        <button id="show-pelatihan" class="btn-outline" style="border-radius: 0.5rem 0.5rem 0 0; flex: 1;">📚 Pelatihan Aktif</button>
        <button id="show-riwayat" class="btn-outline" style="border-radius: 0.5rem 0.5rem 0 0; flex: 1;">✓ Riwayat Selesai</button>
    </div>

    <!-- Members Section -->
    <div id="members-section">
        <div class="member-card">
            <h2 class="page-title-small">Daftar Member</h2>
            <form method="GET" action="{{ route('admin.members.index') }}" style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari nama atau email..." class="form-input" style="flex: 1; min-width: 250px;">
                <button type="submit" class="btn-primary">Cari</button>
            </form>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Layanan</th>
                        <th>Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td><strong>{{ $member->name }}</strong></td>
                            <td><small>{{ $member->email }}</small></td>
                            <td><small>{{ $member->phone ?? '-' }}</small></td>
                            <td>
                                <small>
                                    @if($member->selected_services)
                                        @foreach(array_slice($member->selected_services, 0, 2) as $service)
                                            <span style="background: var(--light-color); padding: 0.25rem 0.5rem; border-radius: 0.3rem; margin-right: 0.25rem;">{{ $service }}</span>
                                        @endforeach
                                        @if(count($member->selected_services) > 2)
                                            <span style="background: var(--light-color); padding: 0.25rem 0.5rem; border-radius: 0.3rem;">+{{ count($member->selected_services) - 2 }}</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </small>
                            </td>
                            <td><small>{{ $member->updated_at->format('d M Y') }}</small></td>
                            <td class="table-actions">
                                <a href="{{ route('admin.members.edit', $member) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus member ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: #999;">
                                📋 Belum ada member. <a href="{{ route('admin.members.create') }}" style="color: var(--primary-color);">Tambah member pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pelatihan Section -->
    <div id="pelatihan-section" style="display: none;">
        <div class="member-card">
            <h2 class="page-title-small">Pelatihan Member Aktif</h2>
            <p style="color: #666; margin: 0;">Status semua pelatihan member yang sedang berlangsung.</p>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Pelatihan</th>
                        <th>Status</th>
                        <th>Tanggal Ambil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikats as $sert)
                        <tr>
                            <td><strong>{{ $sert->user->name }}</strong></td>
                            <td>{{ Str::limit($sert->pelatihan->title, 35) }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($sert->status) }}">
                                    @if($sert->status === 'pending')
                                        ⏳ Menunggu
                                    @elseif($sert->status === 'in_progress')
                                        ▶️ Berlangsung
                                    @endif
                                </span>
                            </td>
                            <td><small>{{ $sert->created_at->format('d M Y') }}</small></td>
                            <td class="table-actions">
                                @if($sert->status === 'pending')
                                    <form method="POST" action="/admin/members/sertifikat/{{ $sert->id }}/confirm" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Konfirmasi pelatihan ini?')">Konfirmasi</button>
                                    </form>
                                @elseif($sert->status === 'in_progress')
                                    <form method="POST" action="/admin/sertifikat/{{ $sert->id }}/complete" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Selesaikan dan terbitkan sertifikat?')">Selesaikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: #999;">
                                ✓ Tidak ada pelatihan yang perlu dikelola
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Section -->
    <div id="riwayat-section" style="display: none;">
        <div class="member-card">
            <h2 class="page-title-small">Riwayat Pelatihan Selesai</h2>
            <p style="color: #666; margin: 0;">Pelatihan member yang sudah menerima sertifikat.</p>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Pelatihan</th>
                        <th>Status</th>
                        <th>Tanggal Selesai</th>
                        <th>Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completedSertifikats as $sert)
                        <tr>
                            <td><strong>{{ $sert->user->name }}</strong></td>
                            <td>{{ Str::limit($sert->pelatihan->title, 35) }}</td>
                            <td>
                                <span class="status-badge status-completed">
                                    ✓ @if($sert->status === 'completed')
                                        Selesai
                                    @elseif($sert->status === 'issued')
                                        Sertifikat
                                    @endif
                                </span>
                            </td>
                            <td><small>{{ $sert->updated_at->format('d M Y') }}</small></td>
                            <td>
                                @if($sert->file_path)
                                    <a href="{{ $sert->file_path }}" target="_blank" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">📥 Download</a>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: #999;">
                                📋 Belum ada riwayat pelatihan yang selesai
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
    document.getElementById('show-members').addEventListener('click', function() {
        document.getElementById('members-section').style.display = 'block';
        document.getElementById('pelatihan-section').style.display = 'none';
        document.getElementById('riwayat-section').style.display = 'none';
        this.className = 'btn-primary';
        this.style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-pelatihan').className = 'btn-outline';
        document.getElementById('show-pelatihan').style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-riwayat').className = 'btn-outline';
        document.getElementById('show-riwayat').style.borderRadius = '0.5rem 0.5rem 0 0';
    });

    document.getElementById('show-pelatihan').addEventListener('click', function() {
        document.getElementById('members-section').style.display = 'none';
        document.getElementById('pelatihan-section').style.display = 'block';
        document.getElementById('riwayat-section').style.display = 'none';
        this.className = 'btn-primary';
        this.style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-members').className = 'btn-outline';
        document.getElementById('show-members').style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-riwayat').className = 'btn-outline';
        document.getElementById('show-riwayat').style.borderRadius = '0.5rem 0.5rem 0 0';
    });

    document.getElementById('show-riwayat').addEventListener('click', function() {
        document.getElementById('members-section').style.display = 'none';
        document.getElementById('pelatihan-section').style.display = 'none';
        document.getElementById('riwayat-section').style.display = 'block';
        this.className = 'btn-primary';
        this.style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-members').className = 'btn-outline';
        document.getElementById('show-members').style.borderRadius = '0.5rem 0.5rem 0 0';
        document.getElementById('show-pelatihan').className = 'btn-outline';
        document.getElementById('show-pelatihan').style.borderRadius = '0.5rem 0.5rem 0 0';
    });
    </script>
@endsection