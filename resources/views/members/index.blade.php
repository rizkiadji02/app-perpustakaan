@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <style>
        .search-form { display: flex; gap: 8px; align-items: center; margin: 16px 0; }
        .search-form input { padding: 6px; min-width: 240px; }
    </style>
    <h1>Daftar Anggota</h1>

    <p><a href="{{ route('members.create') }}" class="btn">+ Tambah Anggota</a></p>

    <form class="search-form" action="{{ route('members.index') }}" method="GET">
        <label for="search">Cari nama anggota</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}">
        <button type="submit" class="btn">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->nim }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->nomor_telepon }}</td>
                    <td>{{ $member->alamat }}</td>
                    <td>{{ ucfirst($member->status) }}</td>
                    <td>
                        <a href="{{ route('members.show', $member->id) }}">Detail</a>
                        |
                        <a href="{{ route('members.edit', $member->id) }}">Edit</a>
                        |
                        <form class="inline" action="{{ route('members.destroy', $member->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p>{{ $members->appends(request()->query())->links() }}</p>
@endsection