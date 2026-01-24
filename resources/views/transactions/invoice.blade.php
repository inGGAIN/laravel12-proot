<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print px-4">
            <h2 class="font-bold text-2xl text-cyan-600 leading-tight">Detail Tiket</h2>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-cyan-500 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-400 transition-all shadow-lg shadow-cyan-200">
                    <i class="fa-solid fa-print mr-2"></i> Cetak Invoice
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Wrapper Utama Tiket --}}
            <div class="relative bg-white rounded-[1rem] shadow-2xl overflow-hidden border border-cyan-50">
                
                {{-- Efek Lubang Tiket Samping --}}
                <div class="absolute top-1/2 -left-6 w-12 h-12 bg-slate-50 rounded-full z-10 no-print"></div>
                <div class="absolute top-1/2 -right-6 w-12 h-12 bg-slate-50 rounded-full z-10 no-print"></div>

                {{-- Header Tiket --}}
                <div class="bg-cyan-500 p-12 text-white text-center relative overflow-hidden">
                    {{-- Watermark Background --}}
                    <div class="absolute top-0 right-0 opacity-10 transform translate-x-12 -translate-y-12">
                        <i class="fa-solid fa-umbrella-beach text-[250px]"></i>
                    </div>

                    <div class="relative z-20">
                        <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">ExploreIn</h1>
                        <p class="text-[10px] font-black opacity-80 tracking-[0.5em] uppercase mt-4">Official E-Ticket Receipt</p>
                        <div class="mt-6">
                            <span class="bg-white/20 backdrop-blur-md px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30">
                                {{ $transaction->status == 'success' ? 'Confirmed & Paid' : 'Pending Verification' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Konten Tiket --}}
                <div class="px-14 py-12 relative">
                    
                    {{-- Grid Informasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-black uppercase text-cyan-300 mb-2 tracking-widest">Traveler Name</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-500">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>
                                    <p class="font-black text-xl text-slate-800">{{ $transaction->user->name }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-cyan-300 mb-2 tracking-widest">Destination</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-500">
                                        <i class="fa-solid fa-earth-asia"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-lg text-slate-800 leading-none">{{ $transaction->destination->name }}</p>
                                        <p class="text-[9px] text-cyan-500 font-bold uppercase mt-1">{{ $transaction->destination->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:text-right space-y-6">
                            <div>
                                <p class="text-[10px] font-black uppercase text-cyan-300 mb-1 tracking-widest">Invoice ID</p>
                                <p class="font-mono font-black text-xl text-cyan-600">#TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-cyan-300 mb-1 tracking-widest">Issued On</p>
                                <p class="font-black text-lg text-slate-800">{{ $transaction->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $transaction->created_at->format('H:i T') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Garis Perforasi --}}
                    <div class="relative h-px border-b-2 border-dashed border-cyan-100 mb-12">
                        <div class="absolute -top-3 -left-[4.2rem] w-6 h-6 bg-slate-50 rounded-full"></div>
                        <div class="absolute -top-3 -right-[4.2rem] w-6 h-6 bg-slate-50 rounded-full"></div>
                    </div>

                    {{-- Tabel Harga --}}
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 mb-8 text-center md:text-left">
                        <div class="flex flex-col md:flex-row justify-between items-center border-b border-slate-200 pb-6 mb-6">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Price</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-sm font-bold text-slate-700 italic">Tiket {{ $transaction->destination->name }}</p>
                            <p class="text-sm font-black text-slate-800">Rp {{ number_format($transaction->destination->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex justify-between items-center mb-10">
                            <p class="text-sm font-bold text-slate-700 italic">Admin & Service Fee</p>
                            <p class="text-sm font-black text-green-500 uppercase italic">Free</p>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                            <h3 class="text-2xl font-black text-cyan-600 uppercase italic leading-none tracking-tighter">Total Payment</h3>
                            <p class="text-4xl font-black text-cyan-600 leading-none">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Footer Barcode --}}
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-6 opacity-60">
                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest max-w-[200px] text-center md:text-left leading-relaxed">
                            * Tiket ini sah digunakan selama barcode dapat terbaca dengan jelas oleh petugas.
                        </p>
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-barcode text-6xl text-slate-800"></i>
                            <p class="text-[8px] font-mono font-black mt-1">EXPLOREIN-SEC-{{ $transaction->id }}</p>
                        </div>
                    </div>
                </div>

                <div class="h-4 bg-cyan-400/30"></div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; -webkit-print-color-adjust: exact; }
            .py-12 { padding: 0 !important; }
            .shadow-2xl { box-shadow: none !important; }
            .bg-slate-50 { background: white !important; }
            .rounded-[3.5rem] { border-radius: 1.5rem !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</x-app-layout>