<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ultraverse') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <x-navbar :fixed="true" />

    <main class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <section class="relative bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Find Your Dream Property</h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                    Discover beautiful homes, apartments, and properties for sale or rent with Ultraverse.
                </p>
                <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('properti.index') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Browse Properties
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Learn More
                    </a>
                </div>
            </div>
        </section>

        <!-- Featured Properties -->
        <section class="bg-gray-50 dark:bg-gray-800">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mb-8 lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Featured Properties</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">Explore our selection of premium properties handpicked for you.</p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    {{-- Property cards will be dynamically populated here --}}
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mb-8 lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Our Services</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">Everything you need to find, buy, or sell your property.</p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Property Search</h3>
                        <p class="text-gray-500 dark:text-gray-400">Advanced search tools to find your perfect property match.</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Property Listing</h3>
                        <p class="text-gray-500 dark:text-gray-400">List your property and reach thousands of potential buyers.</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Expert Guidance</h3>
                        <p class="text-gray-500 dark:text-gray-400">Professional support throughout your property journey.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white dark:bg-gray-900">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Ultraverse</span>
                </div>
                <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Company</h2>
                        <ul class="text-gray-500 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="{{ route('about') }}" class="hover:underline">About</a>
                            </li>
                            <li>
                                <a href="{{ route('services') }}" class="hover:underline">Services</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} Ultraverse. All Rights Reserved.</span>
            </div>
        </div>
    </footer>
</body>
</html>
