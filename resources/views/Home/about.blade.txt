<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'Ultraverse') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <x-navbar :fixed="true" />

    <main class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <section class="relative bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">About Ultraverse</h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                    Transforming the way people buy, sell, and discover properties.
                </p>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="bg-gray-50 dark:bg-gray-800">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mb-8 lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Our Vision</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">
                        To create a seamless, secure, and transparent real estate marketplace that empowers both buyers and sellers.
                    </p>
                </div>
                
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-2 md:gap-12 md:space-y-0">
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Mission</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            We aim to revolutionize property transactions by providing verified listings, secure authentication, and smart features that make finding or selling property easier than ever.
                        </p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Values</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Our core values are transparency, security, and user empowerment. We believe in creating a trustworthy platform that serves our community's needs.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mb-8 lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Our Team</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">
                        Meet the people dedicated to making your property journey successful.
                    </p>
                </div>
                
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Property Experts</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Our team of licensed real estate professionals ensures all listings meet our quality standards.
                        </p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Tech Innovators</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Our development team works tirelessly to create and maintain cutting-edge features for our platform.
                        </p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Customer Support</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Our dedicated support team is always ready to assist you with any questions or concerns.
                        </p>
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
