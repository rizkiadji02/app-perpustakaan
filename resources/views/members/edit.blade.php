@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <style>
        form.member-form { max-width: 500px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
        textarea { min-height: 90px; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
        .btn { margin-top: 20px; padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    </style>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>
    <h1>Edit Anggota</h1>

    <form class="member-form" action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" maxlength="100" value="{{ old('nama', $member->nama) }}">
        @error('nama')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim" maxlength="20" value="{{ old('nim', $member->nim) }}">
        @error('nim')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="email">Email</label>
        <input type="email" name="email" id="email" maxlength="100" value="{{ old('email', $member->email) }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="nomor_telepon">Nomor Telepon</label>
        <input type="text" name="nomor_telepon" id="nomor_telepon" maxlength="15" value="{{ old('nomor_telepon', $member->nomor_telepon) }}">
        @error('nomor_telepon')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat">{{ old('alamat', $member->alamat) }}</textarea>
        @error('alamat')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="aktif" @selected(old('status', $member->status) === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $member->status) === 'nonaktif')>Nonaktif</option>
        </select>
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn">Perbarui</button>
    </form>
@endsection