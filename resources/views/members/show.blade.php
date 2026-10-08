@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>
    <h1>Detail Anggota</h1>

    <table>
        <tbody>
            <tr><th>Nama</th><td>{{ $member->nama }}</td></tr>
            <tr><th>NIM</th><td>{{ $member->nim }}</td></tr>
            <tr><th>Email</th><td>{{ $member->email }}</td></tr>
            <tr><th>Nomor Telepon</th><td>{{ $member->nomor_telepon }}</td></tr>
            <tr><th>Alamat</th><td>{{ $member->alamat }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($member->status) }}</td></tr>
        </tbody>
    </table>

    <p><a href="{{ route('members.edit', $member->id) }}" class="btn">Edit Anggota</a></p>
@endsection