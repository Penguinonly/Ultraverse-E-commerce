@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <!-- Search Section -->
                    <div class="search-section mb-4">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari properti...">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions mb-4">
                        <div class="row">
                            @if(auth()->user()->role === 'penjual')
                            <div class="col-md-4">
                                <a href="{{ route('properti.rumah') }}" class="btn btn-outline-primary w-100">
                                    Upload Properti
                                </a>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <a href="{{ route('simpan.index') }}" class="btn btn-outline-secondary w-100">
                                    Properti Tersimpan
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('transaksi') }}" class="btn btn-outline-info w-100">
                                    Transaksi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Properties -->
                    <div class="featured-properties">
                        <h4 class="mb-3">Properti Terbaru</h4>
                        <div class="row">
                            @foreach($properties ?? [] as $property)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="{{ $property->image_url ?? asset('images/default-property.jpg') }}" 
                                         class="card-img-top" alt="Property Image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $property->name ?? 'Nama Properti' }}</h5>
                                        <p class="card-text">{{ $property->description ?? 'Deskripsi properti...' }}</p>
                                        <a href="{{ route('properti.detail', $property->id ?? 1) }}" 
                                           class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
