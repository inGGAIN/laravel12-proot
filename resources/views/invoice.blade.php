@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="bg-white p-8 shadow-lg border-t-8 border-green-500 rounded-b-xl">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold uppercase">Invoice Pembayaran</h1>
                <p class="text-gray-500">No. Transaksi: #TRX-{{ $data->id }}</p>
            </div>
            <div class="text-right">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold">LUNAS</span>
            </div>
        </div>

        <div class="mb-8">
            <p class="text-gray-600">Nama Pemesan: <span class="text-black font-semibold">{{ $data->user->name ?? 'User Mahasiswa' }}</span></p>
            <p class="text-gray-600">Tanggal: <span class="text-black font-semibold">{{ $data->created_at->format('d M Y H:i') }}</span></p>
        </div>

        <table class="w-full mb-8 text-left">
            <thead class="border-b-2">
                <tr>
                    <th class="py-2">Deskripsi</th>
                    <th class="py-2">Qty</th>
                    <th class="py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-4 font-medium">Tiket Masuk {{ $data->destination->name }}</td>
                    <td class="py-4">{{ $data->quantity }}</td>
                    <td class="py-4 text-right font-bold text-blue-600">Rp {{ number_format($data->total_price) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <p class="text-sm text-gray-400 mb-4 italic text-center">Terima kasih telah berwisata bersama kami!</p>
            <button onclick="window.print()" class="bg-gray-800 text-white px-6 py-2 rounded-lg text-sm print:hidden">Cetak Invoice</button>
        </div>
    </div>
</div>
@endsection