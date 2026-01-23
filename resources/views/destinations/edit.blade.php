<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6">Edit Destinasi: {{ $destination->name }}</h2>

                <form action="{{ route('wisata.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Destinasi</label>
                        <input type="text" name="name" value="{{ $destination->name }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Lokasi</label>
                        <input type="text" name="location" value="{{ $destination->location }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga</label>
                        <input type="number" name="price" value="{{ $destination->price }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300">{{ $destination->description }}</textarea>
                    </div>

                   <div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">Foto Destinasi</label>
    
    <div class="mb-3">
        <p class="text-xs text-gray-500 mb-1">Pratinjau Foto Baru:</p>
        <img id="image-preview" src="#" alt="Preview" 
             class="hidden w-full max-w-xs h-auto rounded-lg shadow-md border-2 border-dashed border-gray-300 p-2">
    </div>

    <input type="file" name="image" id="image-input" 
           class="w-full border border-gray-300 rounded-lg p-2" 
           accept="image/*">
           
    <p class="text-xs text-gray-500 mt-2 italic">
        Gambar saat ini: <span class="text-blue-600">{{ $destination->image }}</span>
    </p>
</div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('destinations.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            // Tampilkan elemen gambar
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('hidden');
        }
    };
</script>
</x-app-layout>