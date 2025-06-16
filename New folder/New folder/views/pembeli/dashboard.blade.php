@extends('layouts.pembeli')

@section('title', 'Pembeli Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Featured Properties Section -->
    <section class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Featured Properties</h2>
            <a href="{{ route('properti.search') }}" class="text-indigo-600 hover:text-indigo-900">View all</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(session('featured_properties', []) as $property)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($property->images->first())
                <div class="relative h-48">
                    <img class="w-full h-full object-cover" src="{{ asset($property->images->first()->path) }}" alt="{{ $property->title }}">
                    <button 
                        class="absolute top-2 right-2 text-white hover:text-red-500"
                        onclick="toggleSaveProperty({{ $property->id }})"
                    >
                        <svg class="h-6 w-6 {{ in_array($property->id, session('saved_property_ids', [])) ? 'fill-current text-red-500' : 'fill-none' }}" 
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </button>
                </div>
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h3>
                    <p class="text-gray-600">{{ $property->address }}</p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                        <a href="{{ route('properti.show', $property->id) }}" 
                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Stats and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Stats -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Activity</h3>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ session('stats.saved_properties') }}</p>
                            <p class="text-sm text-gray-500">Saved Properties</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ session('stats.active_transactions') }}</p>
                            <p class="text-sm text-gray-500">Active Transactions</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ session('stats.completed_transactions') }}</p>
                            <p class="text-sm text-gray-500">Completed Transactions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                        @foreach(session('recent_activity', []) as $activity)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->title }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $activity->description }}</p>
                                </div>
                                <div class="flex-shrink-0 text-sm text-gray-500">
                                    {{ $activity->time_ago }}
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

@push('scripts')
<script>
function toggleSaveProperty(propertyId) {
    fetch(`/saved-properties/toggle/${propertyId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.is_saved) {
            // Update UI to show saved state
            document.querySelector(`[data-property-id="${propertyId}"] svg`).classList.add('fill-current', 'text-red-500');
        } else {
            // Update UI to show unsaved state
            document.querySelector(`[data-property-id="${propertyId}"] svg`).classList.remove('fill-current', 'text-red-500');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection
