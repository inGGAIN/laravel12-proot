<x-app-layout>
    <div class="py-12 bg-beach-sand/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card Utama --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-beach-blue/5 border border-gray-100 overflow-hidden">
                
                {{-- Header Section --}}
                <div class="p-10 border-b border-gray-50 bg-white flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-gray-800 tracking-tighter uppercase italic">
                            Edit <span class="text-beach-blue">Destinasi</span>
                        </h2>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">
                            ID: #DST-{{ str_pad($destination->id, 4, '0', STR_PAD_LEFT) }} — {{ $destination->name }}
                        </p>
                    </div>
                    <div class="p-3 bg-beach-sand/20 rounded-2xl">
                        <i class="fa-solid fa-pen-to-square text-beach-blue text-xl"></i>
                    </div>
                </div>

                <form action="{{ route('destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data" class="p-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- Nama Destinasi --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/60 ml-1">Nama Wisata</label>
                            <div class="relative group">
                                <i class="fa-solid fa-umbrella-beach absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-beach-blue transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name', $destination->name) }}" 
                                    class="w-full pl-12 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-bold text-gray-700"
                                    placeholder="Contoh: Pantai Pandawa">
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/60 ml-1">Lokasi Wilayah</label>
                            <div class="relative group">
                                <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-beach-blue transition-colors"></i>
                                <input type="text" name="location" value="{{ old('location', $destination->location) }}" 
                                    class="w-full pl-12 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-bold text-gray-700"
                                    placeholder="Contoh: Bali, Indonesia">
                            </div>
                        </div>

                        {{-- Harga --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/60 ml-1">Harga Tiket (Rp)</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-300 group-focus-within:text-beach-blue transition-colors">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $destination->price) }}" 
                                    class="w-full pl-12 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all font-black text-beach-blue"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-8 space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/60 ml-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" 
                            class="w-full px-6 py-4 rounded-[2rem] border-gray-100 bg-gray-50 focus:bg-white focus:border-beach-cyan focus:ring-beach-cyan transition-all text-sm text-gray-600 leading-relaxed font-medium"
                            placeholder="Ceritakan keindahan destinasi ini...">{{ old('description', $destination->description) }}</textarea>
                    </div>

                    {{-- Section Foto --}}
                    <div class="mb-10 p-8 bg-beach-sand/20 rounded-[2rem] border border-beach-sand/50 relative overflow-hidden">
                        {{-- Dekorasi Icon --}}
                        <i class="fa-solid fa-camera absolute -right-4 -bottom-4 text-beach-blue/5 text-8xl rotate-12"></i>
                        
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-beach-blue/80 mb-6 text-center md:text-left">Pembaruan Visual</label>
                        
                        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start relative z-10">
                            {{-- Image Container --}}
                            <div class="relative w-48 h-48 shrink-0 overflow-hidden rounded-[2rem] bg-white border-4 border-white shadow-lg group">
                                <img id="image-preview" 
                                    src="{{ $destination->image ? asset('storage/' . $destination->image) : '#' }}" 
                                    class="{{ $destination->image ? '' : 'hidden' }} w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                
                                <div id="image-placeholder" class="{{ $destination->image ? 'hidden' : '' }} flex flex-col items-center justify-center h-full p-4 text-center">
                                    <i class="fa-solid fa-image text-beach-blue/20 text-4xl mb-2"></i>
                                    <p class="text-[8px] text-gray-400 font-black uppercase tracking-widest">No Preview</p>
                                </div>
                            </div>

                            {{-- Input & Info --}}
                            <div class="flex-1 w-full space-y-4">
                                <div class="relative">
                                    <input type="file" name="image" id="image-input" 
                                        class="hidden"
                                        accept="image/*">
                                    <label for="image-input" class="inline-flex items-center justify-center w-full md:w-auto px-8 py-4 bg-beach-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-beach-cyan transition-all cursor-pointer shadow-lg shadow-beach-blue/20">
                                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Pilih Foto Baru
                                    </label>
                                </div>
                                
                                <div class="p-5 bg-white/60 backdrop-blur-sm rounded-2xl border border-white">
                                    <p class="text-[9px] text-gray-400 font-black uppercase tracking-tighter mb-1">File Aktif:</p>
                                    <p class="text-[10px] text-beach-blue font-mono truncate bg-beach-sand/30 px-3 py-1.5 rounded-lg border border-beach-sand/50">
                                        {{ $destination->image ? basename($destination->image) : 'Belum ada foto yang diunggah' }}
                                    </p>
                                    <p class="text-[9px] text-red-400 font-bold italic mt-3 flex items-center">
                                        <i class="fa-solid fa-circle-info mr-1 text-[8px]"></i>
                                        Kosongkan jika tidak ingin mengubah foto.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col md:flex-row justify-end gap-4 pt-6 border-t border-gray-50">
                        <a href="{{ route('destinations.index') }}" 
                           class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all text-center">
                            Batalkan
                        </a>
                        <button type="submit" 
                            class="px-10 py-4 bg-beach-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-beach-cyan transition-all shadow-xl shadow-beach-blue/20 transform hover:-translate-y-0.5 active:scale-95">
                            Simpan Perubahan
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