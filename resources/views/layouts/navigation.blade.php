<div class="flex justify-between h-16 w-full">
    
    <div class="flex">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Katalog Wisata') }}
            </x-nav-link>
        </div>
    </div>

    <div class="hidden sm:flex sm:items-center sm:ms-6">
        @if (Route::has('login'))
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-gray-500">Halo, {{ Auth::user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline font-semibold">Login</a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>