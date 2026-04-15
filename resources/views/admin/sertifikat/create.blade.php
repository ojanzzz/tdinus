@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Terbitkan Sertifikat</h1>

<form method="POST" action="{{ route('admin.sertifikat.store') }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    <label>
        Member
        <select name="user_id" class="form-input" required>
            <option value="">Pilih Member</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                <option value="{{ $p->id }}" {{ old('pelatihan_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->title }}
                </option>
            @endforeach
        </select>
    </label>
    <label>
        Tanggal Terbit
        <input type="date" name="issue_date" value="{{ old('issue_date') }}" class="form-input" required>
    </label>
    <label>
        Tanggal Kadaluarsa
        <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="form-input">
    </label>
    <label>
        File Sertifikat (PDF)
        <input type="file" name="file" class="form-input" accept=".pdf">
    </label>
    <label>
        Status
        <select name="status" class="form-input">
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="issued" {{ old('status', 'issued') == 'issued' ? 'selected' : '' }}>Issued</option>
            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            <option value="revoked" {{ old('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
        </select>
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.sertifikat.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Terbitkan</button>
    </div>
</form>
@endsection

