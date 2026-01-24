<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-bold text-2xl text-beach-blue leading-tight">
                {{ __('E-Ticket Invoice') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('booking.history') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-all">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
                <button onclick="window.print()" class="bg-beach-blue text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-beach-cyan transition-all shadow-lg shadow-beach-blue/20">
                    <i class="fa-solid fa-print mr-2"></i> Cetak Tiket
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-beach-sand min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Wrapper Utama dengan Efek Sobekan Tiket --}}
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                
                {{-- Dekorasi Lubang Tiket (Samping Kiri & Kanan) --}}
                <div class="absolute top-1/2 -left-4 w-8 h-8 bg-beach-sand rounded-full z-10 no-print"></div>
                <div class="absolute top-1/2 -right-4 w-8 h-8 bg-beach-sand rounded-full z-10 no-print"></div>

                {{-- Header: Brand & Status --}}
                <div class="bg-beach-blue p-10 text-white relative overflow-hidden">
                    {{-- Dekorasi Pola Ombak Sederhana (SVG/CSS) --}}
                    <div class="absolute top-0 right-0 opacity-10 transform translate-x-10 -translate-y-10">
                        <i class="fa-solid fa-umbrella-beach text-[200px]"></i>
                    </div>

                    <div class="flex justify-between items-center relative z-20">
                        <div>
                            <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">ExploreIn</h1>
                            <p class="text-[10px] font-black opacity-70 tracking-[0.3em] uppercase mt-1">Official Digital Receipt</p>
                        </div>
                        <div class="text-right">
                            <span class="bg-white/20 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30">
                                Confirmed
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Konten Utama --}}
                <div class="p-10 relative">
                    
                    {{-- Info Transaksi Utama --}}
                    <div class="flex flex-col md:flex-row justify-between gap-8 mb-12">
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black uppercase text-beach-blue/40 mb-1 tracking-widest">Traveler Name</p>
                                <p class="font-bold text-xl text-gray-800">{{ $transaction->user->name }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $transaction->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-beach-blue/40 mb-1 tracking-widest">Destination</p>
                                <div class="flex items-center text-gray-800">
                                    <i class="fa-solid fa-location-dot mr-2 text-beach-cyan"></i>
                                    <span class="font-bold">{{ $transaction->destination->name }}</span>
                                </div>
                                <p class="text-xs text-gray-400 ml-5">{{ $transaction->destination->location }}</p>
                            </div>
                        </div>

                        <div class="text-left md:text-right space-y-4">
                            <div>
                                <p class="text-[10px] font-black uppercase text-beach-blue/40 mb-1 tracking-widest">Invoice ID</p>
                                <p class="font-mono font-bold text-lg text-beach-blue">#TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-beach-blue/40 mb-1 tracking-widest">Transaction Date</p>
                                <p class="font-bold text-gray-800">{{ $transaction->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-beach-cyan font-black uppercase">{{ $transaction->created_at->format('H:i T') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Garis Pemisah (Perforasi Tiket) --}}
                    <div class="relative h-px border-b border-dashed border-gray-200 mb-12">
                        <div class="absolute -top-2 -left-12 w-4 h-4 bg-beach-sand rounded-full"></div>
                        <div class="absolute -top-2 -right-12 w-4 h-4 bg-beach-sand rounded-full"></div>
                    </div>

                    {{-- Rincian Biaya --}}
                    <div class="bg-beach-sand/20 rounded-[2rem] p-8 border border-beach-sand/50 mb-8">
                        <table class="w-full">
                            <thead>
                                <tr class="text-[10px] font-black text-beach-blue/40 uppercase tracking-widest">
                                    <th class="text-left pb-4">Description</th>
                                    <th class="text-right pb-4">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-bold text-gray-700">
                                <tr>
                                    <td class="py-2 italic">Tiket Masuk {{ $transaction->destination->name }}</td>
                                    <td class="py-2 text-right">Rp {{ number_format($transaction->destination->price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 italic">Service Fee & Tax</td>
                                    <td class="py-2 text-right text-green-500">Rp 0 (Included)</td>
                                </tr>
                                <tr class="text-xl">
                                    <td class="pt-6 font-black uppercase text-beach-blue">Grand Total</td>
                                    <td class="pt-6 text-right font-black text-beach-blue">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer: Barcode & Catatan --}}
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-t border-gray-50 pt-8">
                        <div class="max-w-xs">
                            <p class="text-[9px] text-gray-400 font-bold leading-relaxed uppercase tracking-tighter italic">
                                * PENTING: Harap simpan e-ticket ini. Petugas akan melakukan scan barcode di pintu masuk utama. Nikmati perjalanan Anda bersama ExploreIn!
                            </p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="text-5xl text-gray-800 mb-1">
                                <i class="fa-solid fa-barcode"></i>
                            </div>
                            <p class="text-[8px] font-mono font-bold text-gray-400 uppercase tracking-[0.5em]">ExploreInSecurity-{{ $transaction->id }}</p>
                        </div>
                    </div>
                </div>

                {{-- Aksen Watermark Bawah --}}
                <div class="h-2 bg-beach-cyan/30"></div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; -webkit-print-color-adjust: exact; }
            .py-12 { padding: 0 !important; }
            .shadow-2xl { box-shadow: none !important; }
            .bg-beach-sand { background: white !important; }
            .rounded-[2.5rem] { border-radius: 0 !important; border: none !important; }
        }
    </style>
</x-app-layout>