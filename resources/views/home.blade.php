<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GRID KATALOG --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($destinations as $item)
                <div class="group bg-white overflow-hidden shadow-sm hover:shadow-2xl rounded-2xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-2">
                    {{-- Image Container --}}
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur text-red-500 text-sm font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">{{ $item->name }}</h3>
                        
                        <p class="text-sm text-cyan-600 mb-4 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $item->location }}
                        </p>
                        
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">
                            {{ $item->description }}
                        </p>

                        <a href="{{ route('wisata.show', $item->id) }}" class="inline-flex items-center w-full justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-700 active:bg-cyan-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition duration-150">
                            Lihat Detail Destinasi
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white p-12 rounded-2xl text-center shadow-sm">
                    <p class="text-gray-400 italic">Belum ada destinasi yang ditemukan.</p>
                </div>
                @endforelse
            </div>

            {{-- NAVIGASI PAGINATION --}}
            <div class="mt-12">
                {{ $destinations->links() }}
            </div>

        </div>
    </div>
</x-app-layout>