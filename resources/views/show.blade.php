<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail: {{ $destination->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <img src="{{ asset('storage/' . $destination->image) }}" class="w-full rounded-lg shadow">
                </div>

                <div class="md:w-1/2">
                    <h1 class="text-4xl font-bold mb-2">{{ $destination->name }}</h1>
                    <p class="text-gray-500 mb-4">{{ $destination->location }}</p>
                    <div class="text-2xl font-bold text-blue-600 mb-6">
                        Rp {{ number_format($destination->price) }}
                    </div>
                    <p class="text-gray-700 mb-8">{{ $destination->description }}</p>

                    <form action="{{ route('checkout', $destination->id) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                        @csrf
                        <div class="flex items-center gap-4">
                            <input type="number" name="qty" value="1" min="1" class="w-20 rounded border-gray-300">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold w-full hover:bg-green-700">
                                Beli Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>