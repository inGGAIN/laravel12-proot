@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <img src="{{ asset('storage/' . $destination->image) }}" class="w-full h-96 object-cover">
        <div class="p-8">
            <h1 class="text-4xl font-bold">{{ $destination->name }}</h1>
            <p class="text-blue-500 font-medium mt-2">{{ $destination->location }}</p>
            <p class="mt-6 text-gray-700 leading-relaxed">{{ $destination->description }}</p>
            
            <div class="mt-10 border-t pt-8">
                <form action="{{ route('checkout', $destination->id) }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Tiket</label>
                        <input type="number" name="qty" value="1" min="1" class="mt-1 border rounded-md p-2 w-20">
                    </div>
                    <button type="submit" class="mt-6 bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700">
                        Beli Tiket - Rp {{ number_format($destination->price) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection