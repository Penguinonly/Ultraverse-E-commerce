@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <h1>Dashboard Overview</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="value">{{ session('stats.total_users', 0) }}</div>
        </div>
        <div class="stat-card">
            <h3>Properties Listed</h3>
            <div class="value">{{ session('stats.total_properties', 0) }}</div>
        </div>
        <div class="stat-card">
            <h3>Pending Verifications</h3>
            <div class="value">{{ session('stats.pending_verifications', 0) }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Transactions</h3>
            <div class="value">{{ session('stats.total_transactions', 0) }}</div>
        </div>
    </div>

    <div class="grid-layout">
        <!-- Recent Users -->
        <div class="data-section">
            <h2>Recent Users</h2>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(session('stats.recent_users', []) as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge role-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $user->is_active ? 'active' : 'inactive' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No recent users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Properties -->
        <div class="data-section">
            <h2>Recent Properties</h2>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Owner</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(session('stats.recent_properties', []) as $property)
                            <tr>
                                <td>
                                    <div class="property-info">
                                        <img src="{{ asset('storage/' . $property->foto_utama) }}" alt="{{ $property->nama }}" class="property-thumb">
                                        <div>
                                            <div class="property-name">{{ $property->nama }}</div>
                                            <div class="property-location">{{ $property->lokasi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $property->user->nama }}</td>
                                <td>Rp {{ number_format($property->harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $property->approved ? 'active' : 'pending' }}">
                                        {{ $property->approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.properti.show', $property->id) }}" class="action-btn btn-primary">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No recent properties</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="data-section">
            <h2>Recent Transactions</h2>
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Property</th>
                            <th>Buyer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(session('stats.recent_transactions', []) as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->properti->nama }}</td>
                                <td>{{ $transaction->user->nama }}</td>
                                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $transaction->status }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $transaction->id) }}" class="action-btn btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No recent transactions</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any dashboard-specific JavaScript here
});
</script>
@endpush
