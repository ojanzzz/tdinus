@extends('layouts.admin')

@section('admin-content')
    <h1 class="page-title">Edit Member</h1>

    <form method="POST" action="{{ route('admin.members.update', $member) }}" class="form-stack form-card">
        @csrf
        @method('PUT')
        <label>
            Nama
            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-input" required>
        </label>
        <label>
            Email
            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="form-input" required>
        </label>

        <label>
            Phone
            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="form-input">
        </label>
        <label>
            Alamat
            <textarea name="address" class="form-input">{{ old('address', $member->address) }}</textarea>
        </label>
        <label>
            Layanan (pilih beberapa)
            <select name="selected_services[]" class="form-input" multiple>
                @foreach($services as $id => $name)
                    <option value="{{ $id }}" {{ in_array($id, $member->selected_services ?? []) ? 'selected' : '' }}>
                        {{ $name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            Password Baru (opsional)
            <input type="password" name="password" class="form-input">
        </label>
        <label>
            Konfirmasi Password
            <input type="password" name="password_confirmation" class="form-input">
        </label>
        @if($errors->any())
            <p class="form-error">{{ $errors->first() }}</p>
        @endif
        <div class="form-actions">
            <a href="{{ route('admin.members.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Update</button>
        </div>
    </form>
@endsection