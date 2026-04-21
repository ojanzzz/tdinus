@extends('layouts.admin')

@section('admin-content')
    <h1 class="page-title">Tambah Member</h1>

    <form method="POST" action="{{ route('admin.members.store') }}" class="form-stack form-card">
        @csrf
        <label>
            Nama
            <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
        </label>
        <label>
            Email
            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
        </label>

        <label>
            Phone
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
        </label>
        <label>
            Alamat
            <textarea name="address" class="form-input">{{ old('address') }}</textarea>
        </label>
        <label>
            Layanan (pilih beberapa)
            <select name="selected_services[]" class="form-input" multiple>
                @foreach($services as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            Password
            <input type="password" name="password" class="form-input" required>
        </label>
        @if($errors->any())
            <p class="form-error">{{ $errors->first() }}</p>
        @endif
        <div class="form-actions">
            <a href="{{ route('admin.members.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
@endsection