@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Sertifikat</h1>

<form method="POST" action="{{ route('admin.sertifikat.update', $sertifikat) }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>
        Member
        <select name="user_id" class="form-input" required>
            <option value="">Pilih Member</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $sertifikat->user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </label>
    <label>
        Pelatihan
        <select name="pelatihan_id" class="form-input" required>
            <option value="">Pilih Pelatihan</option>
            @foreach($pelatihans as $p)
                <option value="{{ $p->id }}" {{ old('pelatihan_id', $sertifikat->pelatihan_id) == $p->id ? 'selected' : '' }}>
                    {{ $p->title }}
                </option>
            @endforeach
        </select>
    </label>
    <label>
        Tanggal Terbit
        <input type="date" name="issue_date" value="{{ old('issue_date', $sertifikat->issue_date) }}" class="form-input" required>
    </label>
    <label>
        Tanggal Kadaluarsa
        <input type="date" name="expiry_date" value="{{ old('expiry_date', $sertifikat->expiry_date) }}" class="form-input">
    </label>
    <label>
        File Sertifikat (kosongkan untuk tetap)
        @if($sertifikat->file_path)
            <a href="{{ $sertifikat->file_path }}" target="_blank">Lihat Saat ini</a>
        @endif
        <input type="file" name="file" class="form-input" accept=".pdf">
    </label>
    <label>
        Status
        <select name="status" class="form-input">
            <option value="pending" {{ old('status', $sertifikat->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ old('status', $sertifikat->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="issued" {{ old('status', $sertifikat->status) == 'issued' ? 'selected' : '' }}>Issued</option>
            <option value="expired" {{ old('status', $sertifikat->status) == 'expired' ? 'selected' : '' }}>Expired</option>
            <option value="revoked" {{ old('status', $sertifikat->status) == 'revoked' ? 'selected' : '' }}>Revoked</option>
        </select>
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.sertifikat.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>
@endsection

