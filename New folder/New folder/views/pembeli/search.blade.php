@extends('layouts.pembeli')

@section('title', 'Search Properties')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="p-6">
            <form action="{{ route('properti.search') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                    <div class="col-span-full md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Search by location, property type...">
                        </div>
                    </div>

                    <div>
                        <label for="priceRange" class="block text-sm font-medium text-gray-700">Price Range</label>
                        <select id="priceRange" name="price_range" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Prices</option>
                            <option value="0-500000000" {{ request('price_range') == '0-500000000' ? 'selected' : '' }}>Under 500 Million</option>
                            <option value="500000000-1000000000" {{ request('price_range') == '500000000-1000000000' ? 'selected' : '' }}>500M - 1B</option>
                            <option value="1000000000-2000000000" {{ request('price_range') == '1000000000-2000000000' ? 'selected' : '' }}>1B - 2B</option>
                            <option value="2000000000-plus" {{ request('price_range') == '2000000000-plus' ? 'selected' : '' }}>Above 2B</option>
                        </select>
                    </div>

                    <div>
                        <label for="propertyType" class="block text-sm font-medium text-gray-700">Property Type</label>
                        <select id="propertyType" name="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Types</option>
                            <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                            <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="land" {{ request('type') == 'land' ? 'selected' : '' }}>Land</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                        <select id="bedrooms" name="bedrooms" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                        <select id="bathrooms" name="bathrooms" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Any</option>
                            <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                        </select>
                    </div>

                    <div>
                        <label for="sortBy" class="block text-sm font-medium text-gray-700">Sort By</label>
                        <select id="sortBy" name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price (High to Low)</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 text-white rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Search Properties
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse(session('properties', []) as $property)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="relative">
                @if($property->images->first())
                <img 
                    class="h-48 w-full object-cover"
                    src="{{ asset($property->images->first()->path) }}" 
                    alt="{{ $property->title }}"
                >
                @endif
                <button 
                    class="absolute top-2 right-2 text-white hover:text-red-500"
                    onclick="toggleSaveProperty({{ $property->id }})"
                    data-property-id="{{ $property->id }}"
                >
                    <svg class="h-6 w-6 {{ in_array($property->id, session('saved_property_ids', [])) ? 'fill-current text-red-500' : 'fill-none' }}" 
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h3>
                <p class="text-gray-600">{{ $property->address }}</p>
                <div class="mt-2 flex justify-between items-center">
                    <span class="text-indigo-600 font-bold">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex space-x-4 text-sm text-gray-600">
                        @if($property->bedrooms)
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ $property->bedrooms }} bed
                        </div>
                        @endif
                        @if($property->bathrooms)
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $property->bathrooms }} bath
                        </div>
                        @endif
                        @if($property->area)
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            {{ $property->area }} m²
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('properti.show', $property->id) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(session('properties', [])->hasPages())
    <div class="mt-6">
        {{ session('properties')->links() }}
    </div>
    @endif
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
        const button = document.querySelector(`[data-property-id="${propertyId}"] svg`);
        if (data.is_saved) {
            button.classList.add('fill-current', 'text-red-500');
        } else {
            button.classList.remove('fill-current', 'text-red-500');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error toggling property save status. Please try again later.');
    });
}
</script>
@endpush
@endsection
