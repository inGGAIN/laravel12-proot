<x-app-layout>
    @if(session('success'))
    <div class="max-w-5xl mx-auto px-4 mt-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
        </div>
    </div>
@endif

    <div class="py-12 bg-beach-sand min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-100">
                
                {{-- Bagian Gambar Utama --}}
                <div class="relative h-[450px]">
                    <img src="{{ asset('storage/' . $destination->image) }}" 
                         alt="{{ $destination->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <span class="bg-beach-orange px-4 py-1.5 rounded-full text-sm font-bold shadow-lg">
                            Rp {{ number_format($destination->price, 0, ',', '.') }}
                        </span>
                        <h1 class="text-4xl font-black mt-4 uppercase tracking-tighter">{{ $destination->name }}</h1>
                    </div>
                </div>

                <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-3 gap-12">
                    {{-- Konten Kiri --}}
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h3 class="text-beach-blue font-bold text-xl mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info"></i> Deskripsi Destinasi
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                {{ $destination->description }}
                            </p>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <h3 class="text-beach-blue font-bold text-xl mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot"></i> Lokasi
                            </h3>
                            <p class="text-gray-600 flex items-center gap-2 italic">
                                <span class="text-beach-cyan"><i class="fa-solid fa-location-dot"></i></span> 
                                {{ $destination->location }}
                            </p>
                        </div>
                    </div>

                    {{-- Konten Kanan (Sidebar Info) --}}
                    <div class="space-y-6">
                        <div class="bg-beach-sand/30 p-6 rounded-2xl border border-beach-cyan/20 shadow-sm">
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest mb-4">Informasi Tambahan</p>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-beach-orange shadow-sm">
                                        <i class="fa-solid fa-ticket"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">Harga Tiket</p>
                                        <p class="font-bold text-gray-800">Rp {{ number_format($destination->price, 0, ',', '.') }}</p>
                                    </div>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-beach-cyan shadow-sm">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">Update Terakhir</p>
                                        <p class="font-bold text-gray-800">{{ $destination->updated_at->format('d M Y') }}</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <form action="{{ route('booking.store', $destination->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full mt-8 bg-beach-blue hover:bg-beach-cyan text-white font-bold py-4 rounded-xl shadow-lg transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-cart-plus"></i> Booking Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>