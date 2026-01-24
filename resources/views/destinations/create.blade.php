<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <div class="py-12 bg-beach-sand/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card Utama --}}
            <div class="bg-white rounded-[1rem] shadow-2xl shadow-beach-blue/10 border border-gray-100 overflow-hidden">
                
                {{-- Decorative Header --}}
                <div class="relative overflow-hidden">
                    <div class="bg-white p-8 rounded-[1rem] flex justify-between items-center">
                        <div>
                            <h2 class="font-black text-2xl text-beach-blue leading-tight uppercase tracking-tighter italic">
                                {{ __('New Destination') }} <span class="text-beach-cyan">Registration</span>
                            </h2>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-beach-blue">Sistem Inventaris Wisata</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase mt-1">Lengkapi data untuk mendaftarkan objek wisata baru.</p>
                        </div>
                        <div class="w-12 h-12 bg-beach-sand/30 rounded-2xl flex items-center justify-center text-beach-blue">
                            <i class="fa-solid fa-map-location-dot text-xl"></i>
                        </div>
                    </div>
                </div>

                <form action="{{ route('destinations.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- Nama Destinasi --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-beach-blue/60 ml-1">Nama Destinasi</label>
                            <div class="relative group">
                                <i class="fa-solid fa-hotel absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-beach-blue transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-bold text-gray-700"
                                    placeholder="Masukkan nama tempat...">
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-beach-blue/60 ml-1">Lokasi / Alamat</label>
                            <div class="relative group">
                                <i class="fa-solid fa-location-arrow absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-beach-blue transition-colors"></i>
                                <input type="text" name="location" value="{{ old('location') }}" 
                                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-bold text-gray-700"
                                    placeholder="Kota, Provinsi">
                            </div>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="mb-8 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-beach-blue/60 ml-1">Harga Tiket Masuk (IDR)</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-300 group-focus-within:text-beach-blue transition-colors">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" 
                                class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-black text-beach-blue"
                                placeholder="0">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-8 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-beach-blue/60 ml-1">Deskripsi Objek Wisata</label>
                        <textarea name="description" rows="5" 
                            class="w-full px-6 py-4 rounded-[2rem] border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all text-sm text-gray-600 leading-relaxed font-medium"
                            placeholder="Gambarkan keunikan dan fasilitas yang tersedia...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Section Foto --}}
                    <div class="mb-10 p-8 bg-beach-sand/10 rounded-[2.5rem] border-2 border-dashed border-beach-sand relative overflow-hidden">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-beach-blue/80 mb-6">Visual Utama Destinasi</label>
                        
                        <div class="flex flex-col md:flex-row gap-8 items-center">
                            {{-- Image Preview Container --}}
                            <div class="relative w-full md:w-56 aspect-square overflow-hidden rounded-3xl bg-white shadow-inner border border-gray-100 flex items-center justify-center group">
                                <img id="image-preview" src="#" alt="Preview" 
                                     class="hidden w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                
                                <div id="image-placeholder" class="text-center p-6">
                                    <div class="w-16 h-16 bg-beach-sand/30 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-camera-retro text-beach-blue/40 text-2xl"></i>
                                    </div>
                                    <p class="text-[9px] text-gray-400 font-black uppercase leading-tight tracking-widest">Awaiting Photo</p>
                                </div>
                            </div>

                            {{-- File Input --}}
                            <div class="flex-1 w-full space-y-4">
                                <div class="relative">
                                    <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                                    <label for="image-input" class="inline-flex items-center justify-center w-full md:w-auto px-8 py-4 bg-beach-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-beach-cyan transition-all cursor-pointer shadow-lg shadow-beach-blue/20 transform hover:-translate-y-1">
                                        <i class="fa-solid fa-cloud-arrow-up mr-2 text-xs"></i> Unggah Gambar
                                    </label>
                                </div>
                                
                                <div class="p-5 bg-white rounded-2xl border border-gray-50">
                                    <h4 class="text-[9px] font-black uppercase text-beach-blue mb-2 italic">Persyaratan File:</h4>
                                    <ul class="text-[9px] text-gray-500 space-y-1 font-bold">
                                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[7px] text-beach-cyan"></i> MAX UKURAN 2MB</li>
                                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[7px] text-beach-cyan"></i> FORMAT JPG, PNG, WEBP</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end items-center gap-4 pt-8 border-t border-gray-50">
                        <a href="{{ route('destinations.index') }}" 
                           class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-all">
                            Batalkan
                        </a>
                        <button type="submit" 
                            class="px-10 py-4 bg-beach-blue hover:bg-beach-cyan text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-beach-blue/20 transform hover:-translate-y-1 active:scale-95">
                            Simpan Ke Katalog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('hidden');
                imagePlaceholder.classList.add('hidden');
            }
        };
    </script>
</x-app-layout>