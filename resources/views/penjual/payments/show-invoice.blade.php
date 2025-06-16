@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar dengan Notifikasi -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Notifikasi</h5>
                </div>
                <div class="card-body notifications-container">
                    @forelse ($notifications as $notification)
                        <div class="notification-item mb-3 p-2 {{ $notification->dibaca ? 'bg-light' : 'bg-primary bg-opacity-10' }} rounded">
                            <h6 class="mb-1">{{ $notification->judul }}</h6>
                            <p class="mb-1 small">{{ $notification->pesan }}</p>
                            <small class="text-muted">{{ $notification->tanggal->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada notifikasi</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Invoice Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Invoice #{{ $payment->reference_number }}</h4>
                    <button onclick="window.print()" class="btn btn-light btn-print">Print Invoice</button>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Dari:</h6>
                            <div><strong>{{ $payment->seller->name }}</strong></div>
                            <div>{{ $payment->seller->email }}</div>
                            <div>{{ $payment->seller->phone }}</div>
                            <div>{{ $payment->seller->address }}</div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h6 class="mb-3">Kepada:</h6>
                            <div><strong>{{ $payment->buyer->name }}</strong></div>
                            <div>{{ $payment->buyer->email }}</div>
                            <div>{{ $payment->buyer->phone }}</div>
                            <div>{{ $payment->buyer->address }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Properti</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $payment->property->name }}</td>
                                    <td>{{ $payment->property->location }}</td>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($payment->notes)
                    <div class="mt-4">
                        <h6>Catatan:</h6>
                        <p class="mb-0">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .notifications-container {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .notification-item {
        transition: background-color 0.3s ease;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    
    @media print {
        .col-md-3,
        .btn-print,
        .notification-item {
            display: none;
        }
        
        .col-md-9 {
            width: 100%;
        }
        
        .card {
            border: none;
        }
        
        .card-header {
            background-color: #fff !important;
            color: #000 !important;
        }
        
        @page {
            size: A4;
            margin: 1cm;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark notifications as read after a delay
    setTimeout(function() {
        const unreadNotifications = document.querySelectorAll('.notification-item:not(.bg-light)');
        unreadNotifications.forEach(function(notification) {
            notification.classList.remove('bg-primary', 'bg-opacity-10');
            notification.classList.add('bg-light');
        });
    }, 2000);
});
</script>
@endpush
@endsection
