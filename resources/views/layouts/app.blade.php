<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ExploreIn') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            .beach-placeholder {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .beach-placeholder::before {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 40px;
        background: rgba(14, 165, 233, 0.05);
        border-radius: 50% 50% 0 0;
    }
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
                    &copy; {{ date('Y') }} Explore<span class="text-beach-cyan">In</span> • Travel Management System by | xynra
                </p>
            </footer>
        </div>
    </body>
</html>