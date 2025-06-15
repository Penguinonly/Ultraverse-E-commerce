@extends('layouts.app')

@section('title', 'Logout')

@section('content')
<div class="logout-container">
    <h2>Keluar dari Sistem</h2>
    <p>Apakah Anda yakin ingin keluar?</p>
    
    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="fas fa-right-from-bracket"></i>
            Keluar
        </button>
    </form>
</div>

<style>
    .logout-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        text-align: center;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-logout {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .btn-logout:hover {
        background-color: #c82333;
    }
</style>
@endsection
