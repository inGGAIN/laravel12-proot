<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ExploreIn') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Smooth scroll & Custom selection */
            html { scroll-behavior: smooth; }
            ::selection { background-color: #73c8d2; color: white; }
            
            /* Scrollbar Tema Beach */
            ::-webkit-scrollbar { width: 10px; }
            ::-webkit-scrollbar-track { background: #fdf5e6; }
            ::-webkit-scrollbar-thumb { background: #73c8d2; border-radius: 10px; border: 3px solid #fdf5e6; }
            ::-webkit-scrollbar-thumb:hover { background: #0046ff; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 selection:bg-beach-cyan/30">
        {{-- Latar belakang utama menggunakan Beach Sand --}}
        <div class="min-h-screen bg-beach-sand">
            
            {{-- Navigasi Utama --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white/70 backdrop-blur-md border-b border-beach-cyan/10 shadow-sm">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="transition-all duration-500 ease-in-out">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main>
                <div class="py-8">
                    {{ $slot }}
                </div>
            </main>

            {{-- Footer Sederhana --}}
            <footer class="py-12 text-center">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/40">
                    &copy; {{ date('Y') }} Explore<span class="text-beach-cyan">In</span> • Travel Management System
                </p>
            </footer>
        </div>
    </body>
</html>