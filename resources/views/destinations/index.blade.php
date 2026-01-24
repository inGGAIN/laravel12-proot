<x-app-layout>
    <div class="py-10 bg-beach-sand/50 min-h-screen" x-data="{ 
        open: false, 
        currentImg: '', 
        allImages: [],
        allNames: [],
        currentIndex: 0,
        init() {
            this.allImages = Array.from(document.querySelectorAll('.dest-img')).map(img => img.src);
            this.allNames = Array.from(document.querySelectorAll('.dest-name')).map(el => el.innerText);
        },
        openLightbox(index) {
            this.currentIndex = index;
            this.currentImg = this.allImages[index];
            this.open = true;
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.allImages.length;
            this.currentImg = this.allImages[this.currentIndex];
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.allImages.length) % this.allImages.length;
            this.currentImg = this.allImages[this.currentIndex];
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Header Tabel --}}
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Manajemen Destinasi</h3>
                        <p class="text-sm text-gray-400">Total: <span class="font-bold text-beach-blue">{{ $destinations->total() }}</span> destinasi terdaftar</p>
                    </div>
                    <a href="{{ route('destinations.create') }}" 
                       class="px-5 py-2.5 bg-beach-blue text-white rounded-xl hover:bg-beach-cyan transition-all duration-300 shadow-md flex items-center gap-2 font-bold text-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Destinasi
                    </a>
                </div>

                {{-- Tabel Destinasi --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-beach-blue uppercase tracking-widest">No</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-beach-blue uppercase tracking-widest">Foto</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-beach-blue uppercase tracking-widest">Nama Destinasi</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-beach-blue uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($destinations as $index => $destination)
                                <tr class="hover:bg-beach-sand/20 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                        {{ ($destinations->currentPage() - 1) * $destinations->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="relative w-16 h-16 group">
                                            @if($destination->image && Storage::disk('public')->exists($destination->image))
        {{-- Jika Foto Ada --}}
        <img src="{{ asset('storage/' . $destination->image) }}" 
             class="dest-img w-16 h-16 object-cover rounded-xl cursor-zoom-in group-hover:opacity-80 transition shadow-sm border border-gray-100"
             @click="openLightbox({{ $index }})" 
             alt="{{ $destination->name }}">
             
        {{-- Icon Zoom hanya muncul jika ada gambar asli --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity">
            <i class="fa-solid fa-magnifying-glass-plus text-white shadow-sm"></i>
        </div>
    @else
        {{-- Foto Alternatif (Placeholder CSS) jika variabel kosong atau file hilang --}}
        <div class="w-16 h-16 rounded-xl flex flex-col items-center justify-center bg-gradient-to-br from-cyan-50 to-blue-50 border border-cyan-100 shadow-inner relative overflow-hidden">
            <i class="fa-solid fa-image text-cyan-200 text-xl"></i>
            <span class="text-[6px] font-black text-cyan-400 uppercase tracking-tighter mt-1">No Visual</span>
            
            {{-- Aksen Dekorasi Pantai --}}
            <i class="fa-solid fa-umbrella-beach absolute -bottom-1 -right-1 text-cyan-500/5 text-2xl rotate-12"></i>
        </div>
    @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="dest-name text-sm font-bold text-gray-800">{{ $destination->name }}</span>
                                        <p class="text-xs text-beach-cyan mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i>{{ $destination->location }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-3">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('destinations.edit', $destination->id) }}" 
                                               class="w-10 h-10 flex items-center justify-center bg-beach-sand text-beach-orange rounded-xl hover:bg-beach-orange hover:text-white transition-all duration-300 shadow-sm"
                                               title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('destinations.destroy', $destination->id) }}" 
                                                method="POST" 
                                                id="delete-form-{{ $destination->id }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('{{ $destination->id }}', '{{ $destination->name }}')"
                                                        class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm"
                                                        title="Hapus">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fa-solid fa-folder-open text-4xl text-gray-200 mb-3"></i>
                                            <p class="text-gray-400 italic">Belum ada data destinasi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

               {{-- Di resources/views/transactions/index.blade.php --}}
                <div class="p-8 bg-white border-t border-gray-100 pagination-beach">
                    {{ $destinations->links() }}
                </div>

                <style>
                    /* Mengubah warna tombol aktif menjadi Beach Cyan */
                    .pagination-beach nav span[aria-current="page"] span {
                        background-color: #73c8d2 !important; /* beach-cyan */
                        border-color: #73c8d2 !important;
                        color: white !important;
                    }
                    
                    /* Mengubah warna hover tombol angka */
                    .pagination-beach nav a:hover {
                        background-color: #fdf5e6 !important; /* beach-sand */
                        color: #0046ff !important; /* beach-blue */
                    }

                    /* Mengubah warna panah prev/next */
                    .pagination-beach nav svg {
                        color: #73c8d2;
                    }
                </style>
            </div>
        </div>

        {{-- LIGHTBOX MODAL --}}
        <div x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-50"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-50"
            {{-- Perubahan Warna Latar di Sini: bg-black/50 dan backdrop-blur --}}
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-6 backdrop-blur-md"
            style="display: none;"
            @click.away="open = false"
            @keydown.right.window="next()"
            @keydown.left.window="prev()"
            @keydown.escape.window="open = false">
            
            {{-- Tombol Close --}}
            <button @click="open = false" class="absolute top-10 right-10 text-white/70 hover:text-white text-4xl transition-all z-[110]">&times;</button>

            {{-- Navigasi --}}
            <button @click="prev()" class="absolute left-10 text-white/40 hover:text-white text-6xl transition-all transform hover:scale-110 z-[110]">&lsaquo;</button>
            <button @click="next()" class="absolute right-10 text-white/40 hover:text-white text-6xl transition-all transform hover:scale-110 z-[110]">&rsaquo;</button>

            <div class="flex flex-col items-center max-w-4xl w-full">
                <img :src="currentImg" 
                    class="max-w-full max-h-[70vh] rounded-[2rem] shadow-2xl border-4 border-white/20 object-contain shadow-black/50">
                
                <div class="mt-8 text-center bg-black/20 backdrop-blur-xl px-10 py-4 rounded-3xl border border-white/10">
                    <h4 class="text-white text-xl font-black uppercase tracking-widest" x-text="allNames[currentIndex]"></h4>
                    <p class="text-cyan-400 font-black text-[10px] mt-2 uppercase tracking-[0.3em]" x-text="(currentIndex + 1) + ' / ' + allImages.length"></p>
                </div>
            </div>
        </div>
    </div>
    \
    <script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Destinasi?',
        text: `Data "${name}" akan dihapus permanen dan tidak bisa dikembalikan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', // Warna Merah (Destructive)
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus Sekarang!',
        cancelButtonText: 'Batal',
        reverseButtons: true, // Tombol konfirmasi di kanan
        customClass: {
            popup: 'rounded-[2.5rem]',
            confirmButton: 'rounded-2xl font-black uppercase tracking-widest text-[10px] px-6 py-3',
            cancelButton: 'rounded-2xl font-black uppercase tracking-widest text-[10px] px-6 py-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form secara manual jika user klik Ya
            document.getElementById(`delete-form-${id}`).submit();
        }
    })
}
</script>
</x-app-layout>