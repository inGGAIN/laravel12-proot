@section('content')
<div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Daftar Pariwisata</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($destinations as $item)
                <div class="border rounded-lg overflow-hidden shadow">
                        <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                                <h2 class="text-xl font-bold">{{ $item->name }}</h2>
                                <p class="text-gray-600">{{ Str::limit($item->description, 100) }}</p>
                                <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($item->price) }}</p>
                                <a href="{{ route('wisata.show', $item->id) }}" class="block mt-4 text-center bg-blue-500 text-white py-2 rounded">Lihat Detail</a>
                        </div>
                </div>
        @endforeach
        </div>
</div>
@endsection
