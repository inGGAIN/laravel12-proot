<div class="flex justify-between h-20 w-full px-4 sm:px-6 lg:px-8 bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-beach-sand">
    
    <div class="flex items-center">
        <div class="shrink-0 flex items-center group">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="p-2 bg-beach-blue rounded-xl group-hover:rotate-12 transition-transform duration-300">
                    <x-application-logo class="block h-7 w-auto fill-current text-white" />
                </div>
                <span class="font-black text-xl tracking-tighter text-beach-blue uppercase ml-1">Explore<span class="text-beach-cyan">In</span></span>
            </a>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex h-full">
            @auth
            @if(auth()->user()->role === 'admin')
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none 
                {{ request()->routeIs('dashboard') ? 'border-beach-cyan text-beach-blue' : 'border-transparent text-gray-400 hover:text-beach-blue hover:border-beach-sand' }}">
                <i class="fa-solid fa-house-chimney mr-2 text-xs"></i> {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')" 
            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none 
            {{ request()->routeIs('destinations.*') ? 'border-beach-cyan text-beach-blue' : 'border-transparent text-gray-400 hover:text-beach-blue hover:border-beach-sand' }}">
            <i class="fa-solid fa-map-location-dot mr-2 text-xs"></i> {{ __('Destinasi') }}
            </x-nav-link>
            <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" 
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none 
                {{ request()->routeIs('transactions.*') ? 'border-beach-cyan text-beach-blue' : 'border-transparent text-gray-400 hover:text-beach-blue hover:border-beach-sand' }}">
                <i class="fa-solid fa-ticket mr-2 text-xs"></i> {{ __('Booking') }}
            </x-nav-link>
            @endif
            @endauth
            @auth
            @if(Auth::user()->role === 'user')
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none 
                {{ request()->routeIs('home') ? 'border-beach-cyan text-beach-blue' : 'border-transparent text-gray-400 hover:text-beach-blue hover:border-beach-sand' }}">
                <i class="fa-solid fa-compass mr-2 text-xs"></i> {{ __('Destinasi') }}
            </x-nav-link>
            <x-nav-link :href="route('my-bookings')" :active="request()->routeIs('my-bookings')">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-xs"></i> {{ __('Bookingan') }}
            </x-nav-link>
           <x-nav-link :href="route('booking.history')" :active="request()->routeIs('booking.history')">
                {{ __('Riwayat') }}
            </x-nav-link>
            @endif
            @endauth
        </div>
    </div>

    <div class="hidden sm:flex sm:items-center sm:ms-6">
    @if (Route::has('login'))
        <div class="flex items-center space-x-6">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-4 py-2 bg-beach-sand/30 rounded-2xl border border-beach-sand hover:bg-beach-sand/50 transition-all duration-300 focus:outline-none">
                            <div class="w-8 h-8 bg-beach-blue rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-beach-blue">{{ Auth::user()->name }}</span>
                            
                            <i class="fa-solid fa-chevron-down text-[10px] text-beach-blue ml-1"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-4 border-b border-gray-100 bg-beach-sand/10">
                            <p class="text-[10px] font-black uppercase text-beach-blue opacity-50 tracking-tighter">Status Akun</p>
                            <p class="text-xs font-bold text-gray-700 uppercase">{{ Auth::user()->role }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="text-xs font-bold uppercase tracking-widest text-gray-600 hover:text-beach-blue">
                            <i class="fa-solid fa-user-gear mr-2"></i> {{ __('Pengaturan') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-xs font-black uppercase tracking-widest text-red-500 hover:bg-red-50 transition-all">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                
            @else
                <a href="{{ route('login') }}" class="text-sm text-beach-blue font-black uppercase tracking-widest hover:text-beach-cyan transition">Login</a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-beach-blue hover:bg-beach-cyan text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300 shadow-lg shadow-beach-blue/20 transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
</div>