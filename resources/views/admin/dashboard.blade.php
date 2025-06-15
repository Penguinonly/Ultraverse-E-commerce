@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
        <p class="text-3xl font-bold text-gray-900">{{ session('stats.total_users') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Properties Listed</h3>
        <p class="text-3xl font-bold text-gray-900">{{ session('stats.total_properties') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Pending Verifications</h3>
        <p class="text-3xl font-bold text-gray-900">{{ session('stats.pending_verifications') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Transactions</h3>
        <p class="text-3xl font-bold text-gray-900">{{ session('stats.total_transactions') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
            <div class="mt-4">
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                        @foreach(session('stats.recent_users', []) as $user)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->nama }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                                <div class="inline-flex items-center text-sm font-semibold text-indigo-600">
                                    {{ $user->role }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">Recent Properties</h3>
            <div class="mt-4">
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                        @foreach(session('stats.recent_properties', []) as $property)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $property->title }}</p>
                                    <p class="text-sm text-gray-500 truncate">Listed by: {{ $property->user->nama }}</p>
                                </div>
                                <div class="inline-flex items-center text-sm font-semibold text-indigo-600">
                                    View Details
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
