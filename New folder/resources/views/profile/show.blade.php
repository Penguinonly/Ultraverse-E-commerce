@extends('layouts.app')

@section('title', 'Profil Saya')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="sidebar">
        <div class="sidebar-icons">
            <a href="{{ route('dashboard_search') }}" class="icon" title="Beranda">
                <i class="fas fa-home"></i>
            </a>
            <a href="{{ route('dokumen') }}" class="icon" title="Dokumen">
                <i class="fas fa-file-alt"></i>
            </a>
            <a href="{{ route('simpan') }}" class="icon" title="Tersimpan">
                <i class="fas fa-bookmark"></i>
            </a>
            <a href="{{ route('chat') }}" class="icon" title="Chat">
                <i class="fas fa-comments"></i>
            </a>
            <div class="spacer"></div>
            <a href="{{ route('profile.show') }}" class="icon active" title="Profil">
                <i class="fas fa-user"></i>
            </a>
            <a href="{{ route('notifications') }}" class="icon" title="Notifikasi">
                <i class="fas fa-bell"></i>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="profile-header">
            <h1>Profil Saya</h1>
            <a href="{{ route('profile.edit') }}" class="edit-button">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                Profil berhasil diperbarui!
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-info">
                <div class="info-group">
                    <label>Nama</label>
                    <p>{{ $user->name }}</p>
                </div>

                <div class="info-group">
                    <label>Email</label>
                    <p>{{ $user->email }}</p>
                </div>

                <div class="info-group">
                    <label>No. Telepon</label>
                    <p>{{ $user->phone ?? '-' }}</p>
                </div>

                <div class="info-group">
                    <label>Alamat</label>
                    <p>{{ $user->address ?? '-' }}</p>
                </div>

                <div class="info-group">
                    <label>Peran</label>
                    <p>{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>

        <div class="danger-zone">
            <h2>Zona Berbahaya</h2>
            <form method="POST" action="{{ route('profile.destroy') }}" class="delete-account-form">
                @csrf
                @method('DELETE')
                
                <p>Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                
                <button type="submit" class="delete-button" 
                    onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                    Hapus Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
