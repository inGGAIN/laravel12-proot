<x-app-layout>
    <div class="py-12 bg-beach-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 bg-white flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-beach-blue">Pesanan Menunggu Konfirmasi</h3>
                        <p class="text-xs text-gray-400">Anda masih bisa membatalkan pesanan sebelum dikonfirmasi admin.</p>
                    </div>
                    {{-- Hapus bagian <td> yang tadi ada di sini karena merusak tata letak --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-8 py-5 text-left">Destinasi</th>
                                <th class="px-8 py-5 text-left">Tanggal Pesan</th>
                                <th class="px-8 py-5 text-center">Total Bayar</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
    @forelse($bookings as $booking)
    <tr class="hover:bg-beach-sand/20 transition-all">
        <td class="px-8 py-6">
            <div class="text-sm font-bold text-gray-800">{{ $booking->destination->name }}</div>
            <div class="text-[10px] text-beach-blue font-bold uppercase tracking-tighter">ID: #TRX-{{ $booking->id }}</div>
        </td>
        <td class="px-8 py-6 text-sm text-gray-600">
            {{ $booking->created_at->format('d M Y, H:i') }}
        </td>
        <td class="px-8 py-6 text-center font-black text-beach-blue">
            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
        </td>
        <td class="px-8 py-6 text-center">
            {{-- Badge Status --}}
            @if($booking->status == 'success')
                <span class="px-4 py-1.5 bg-green-100 text-green-700 text-[10px] font-black uppercase rounded-full">
                    <i class="fa-solid fa-check-double mr-1"></i> Terkonfirmasi
                </span>
            @elseif($booking->status == 'cancel')
                <span class="px-4 py-1.5 bg-red-100 text-red-700 text-[10px] font-black uppercase rounded-full">
                    Dibatalkan
                </span>
            @else
                <span class="px-4 py-1.5 bg-amber-100 text-amber-700 text-[10px] font-black uppercase rounded-full">
                    Menunggu
                </span>
            @endif
        </td>
        <td class="px-8 py-6 text-center">
            <div class="flex items-center justify-center gap-3">
                @if($booking->status == 'pending')
                    {{-- Hanya tampilkan tombol Batal jika status masih Pending --}}
                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all duration-300">
                            <i class="fa-solid fa-trash-can mr-1"></i> Batal
                        </button>
                    </form>
                @elseif($booking->status == 'success')
                    {{-- Tampilkan tombol Invoice HANYA jika status Success --}}
                    <a href="{{ route('booking.invoice', $booking->id) }}" 
                        class="bg-cyan-50 text-cyan-600 hover:bg-cyan-600 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all duration-300 flex items-center gap-2 border border-cyan-100">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span>Invoice</span>
                    </a>
                @else
                    {{-- Jika status Batal, tidak menampilkan tombol aksi apa-apa --}}
                    <span class="text-gray-300 italic text-[10px]">Cancelled</span>
                @endif
            </div>
        </td>
    </tr>
    @empty
    {{-- ... bagian empty tetap sama ... --}}
    @endforelse
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>