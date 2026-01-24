<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-beach-blue leading-tight">
            {{ __('Riwayat Perjalanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-beach-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 bg-white">
                    <h3 class="text-sm font-black uppercase tracking-widest text-beach-blue">Arsip Transaksi</h3>
                    <p class="text-xs text-gray-400">Daftar perjalanan Anda yang sudah selesai atau dibatalkan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-8 py-5 text-left">Destinasi</th>
                                <th class="px-8 py-5 text-left">Tanggal</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Total Bayar</th>
                                <th class="px-8 py-5 text-center">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($history as $item) {{-- Kita gunakan $item di sini --}}
                            <tr class="hover:bg-beach-sand/20 transition-all">
                                <td class="px-8 py-6 font-bold text-gray-800">
                                    {{ $item->destination->name }}
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-400">
                                    {{ $item->updated_at->format('d M Y') }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-4 py-1.5 text-[10px] font-black uppercase rounded-full 
                                        {{ $item->status == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-beach-blue">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($item->status == 'success')
                                        <a href="{{ route('invoice', $item->id) }}" 
                                           class="inline-flex items-center gap-2 bg-beach-blue/10 text-beach-blue hover:bg-beach-blue hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all">
                                            <i class="fa-solid fa-file-invoice"></i> E-Ticket
                                        </a>
                                    @else
                                        <span class="text-gray-300 italic text-[10px]">No Invoice</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">
                                    Belum ada riwayat transaksi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($history->hasPages())
                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    {{ $history->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>