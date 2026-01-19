@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl">Explore Destinasi Wisata</h1>
    <div class="grid">
        @foreach ($destinations as $item)
        <div class="bg-white">
            <img src="{{ asset('storage/'.$item->image) }}" alt="">
            <div class="p-5">
                <h2 class="text-xl">{{ $item->name }}</h2>
                <p class="text-gray-600">Rp {{ ($item->location) }}</p>
                <div class="mt-4">
                    <span class="text-blue-600">{{  number_format($item->price) }}</span>
                    <a href="/wisata/{{ $item->id }}" class="bg-blue-500">Detail</a>
                </div>
            </div>
        </div>        
        @endforeach
    </div>
</div>
@endsection