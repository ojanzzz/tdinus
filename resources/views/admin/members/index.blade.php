@extends('layouts.admin')

@section('admin-content')
    <div class="admin-header">
        <div>
            <h1 class="page-title">Member</h1>
            <p class="page-subtitle">Kelola akun member dan pelatihan.</p>
        </div>
        <div class="admin-header-actions">
            <button id="show-members" class="btn-primary">Member</button>
            <button id="show-pelatihan" class="btn-outline">Pelatihan Member</button>
            <button id="show-riwayat" class="btn-outline">Riwayat Pelatihan Member</button>
            <a href="{{ route('admin.members.create') }}" class="btn-primary">Tambah Member</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div id="members-section">
        <div class="member-card">
            <h2 class="page-title-small">Daftar Member</h2>
            <form method="GET" action="{{ route('admin.members.index') }}" class="form-stack">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-input">
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
                        <th>Alamat</th>
                        <th>Layanan</th>
                        <th>Terakhir Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>{{ Str::limit($member->address ?? '-', 30) }}</td>
                            <td>{{ $member->selected_services ? implode(', ', $member->selected_services) : '-' }}</td>
                            <td>{{ $member->updated_at->format('d M Y') }}</td>
                            <td class="table-actions">
                                <a href="{{ route('admin.members.edit', $member) }}" class="btn-outline">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger"
                                        onclick="return confirm('Hapus member ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada member.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="pelatihan-section" style="display: none;">
        <div class="member-card">
            <h2 class="page-title-small">Pelatihan Member</h2>
            <p>Status semua pelatihan member yang sudah konfirmasi dan menunggu konfirmasi.</p>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Pelatihan</th>
                        <th>Status & Update</th>
                        <th>Tanggal Ambil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikats as $sert)
                        <tr>
                            <td>{{ $sert->user->name }}</td>
                            <td>{{ $sert->pelatihan->title }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($sert->status) }}">
                                    @if($sert->status === 'pending')
                                        Menunggu Konfirmasi
                                    @elseif($sert->status === 'in_progress')
                                        Terkonfirmasi
                                    @endif
                                </span>
                                <br>
                                <form method="POST" action="/admin/members/sertifikat/{{ $sert->id }}/update-status" style="display: inline-block; margin-top: 5px;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-input" style="width: auto; display: inline-block; font-size: 12px;">
                                        <option value="pending" {{ $sert->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $sert->status === 'in_progress' ? 'selected' : '' }}>Terkonfirmasi</option>
                                    </select>
                                    <button type="submit" class="btn-outline" style="margin-left: 5px; font-size: 12px;">Update</button>
                                </form>
                            </td>
                            <td>{{ $sert->issue_date->format('d M Y') }}</td>
                            <td class="table-actions">
                                @if($sert->status === 'pending')
                                    <form method="POST" action="/admin/members/sertifikat/{{ $sert->id }}/confirm" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary" onclick="return confirm('Konfirmasi pelatihan ini?')">Konfirmasi</button>
                                    </form>
                                    <form method="POST" action="/admin/members/sertifikat/{{ $sert->id }}/reject" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-danger" onclick="return confirm('Tolak pelatihan ini?')">Tolak</button>
                                    </form>
                                @elseif($sert->status === 'in_progress')
                                    <form method="POST" action="/admin/sertifikat/{{ $sert->id }}/complete" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary" onclick="return confirm('Selesaikan pelatihan ini dan issue sertifikat?')">Selesaikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada pelatihan yang perlu dikelola.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="riwayat-section" style="display: none;">
        <div class="member-card">
            <h2 class="page-title-small">Riwayat Pelatihan Member</h2>
            <p>Riwayat pelatihan member yang sudah menerima sertifikat.</p>
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
                            <td>{{ $sert->user->name }}</td>
                            <td>{{ $sert->pelatihan->title }}</td>
                            <td>
                                <span class="status-badge status-completed">
                                    @if($sert->status === 'completed')
                                        Selesai
                                    @elseif($sert->status === 'issued')
                                        Sertifikat Diterbitkan
                                    @endif
                                </span>
                            </td>
                            <td>{{ $sert->updated_at->format('d M Y') }}</td>
                            <td>
                                @if($sert->file_path)
                                    <a href="{{ $sert->file_path }}" target="_blank" class="btn-primary">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada riwayat pelatihan yang selesai.</td>
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
        document.getElementById('show-pelatihan').className = 'btn-outline';
        document.getElementById('show-riwayat').className = 'btn-outline';
    });
    document.getElementById('show-pelatihan').addEventListener('click', function() {
        document.getElementById('members-section').style.display = 'none';
        document.getElementById('pelatihan-section').style.display = 'block';
        document.getElementById('riwayat-section').style.display = 'none';
        this.className = 'btn-primary';
        document.getElementById('show-members').className = 'btn-outline';
        document.getElementById('show-riwayat').className = 'btn-outline';
    });
    document.getElementById('show-riwayat').addEventListener('click', function() {
        document.getElementById('members-section').style.display = 'none';
        document.getElementById('pelatihan-section').style.display = 'none';
        document.getElementById('riwayat-section').style.display = 'block';
        this.className = 'btn-primary';
        document.getElementById('show-members').className = 'btn-outline';
        document.getElementById('show-pelatihan').className = 'btn-outline';
    });
    </script>
@endsection