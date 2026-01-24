<x-app-layout>
    <div class="py-12 bg-beach-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-black uppercase tracking-widest text-beach-blue">Seluruh List Order</h3>
                    <span class="bg-beach-blue/10 text-beach-blue px-4 py-1 rounded-full text-xs font-bold">
                        Total: {{ $transactions->total() }} Order
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-8 py-5 text-left">Kode / Tgl</th>
                                <th class="px-8 py-5 text-left">Customer</th>
                                <th class="px-8 py-5 text-left">Destinasi</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Total</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($transactions as $trx)
                            <tr class="hover:bg-beach-sand/20 transition-all">
                                <td class="px-8 py-6">
                                    <span class="text-beach-blue font-black block">#BK-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-gray-800">{{ $trx->user->name }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-gray-700">{{ $trx->destination->name }}</span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span id="status-badge-{{ $trx->id }}" 
                                        class="px-4 py-1.5 text-[10px] font-black uppercase rounded-full
                                        {{ $trx->status == 'success' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $trx->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $trx->status == 'cancel' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-beach-blue">
                                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6 text-center relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-beach-blue p-2">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    {{-- Dropdown Pilihan --}}
                                    <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden text-left">
                                        <button @click="updateStatus({{ $trx->id }}, 'success'); open = false" class="w-full px-4 py-3 text-[10px] font-bold text-green-600 hover:bg-green-50 transition flex items-center gap-2"><i class="fa-solid fa-check"></i> Konfirmasi</button>
                                        <button @click="updateStatus({{ $trx->id }}, 'pending'); open = false" class="w-full px-4 py-3 text-[10px] font-bold text-yellow-600 hover:bg-yellow-50 transition border-y border-gray-50 flex items-center gap-2"><i class="fa-solid fa-clock"></i> Pending</button>
                                        <button @click="updateStatus({{ $trx->id }}, 'cancel'); open = false" class="w-full px-4 py-3 text-[10px] font-bold text-red-600 hover:bg-red-50 transition flex items-center gap-2"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-8 bg-gray-50 border-t border-gray-100">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Script AJAX Status (sama dengan di dashboard) --}}
    <script>
        function updateStatus(id, nextStatus) {
            fetch(`/transactions/${id}/status`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ status: nextStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    badge.innerText = data.new_status;
                    badge.className = 'px-4 py-1.5 text-[10px] font-black uppercase rounded-full transition-all ';
                    if (data.new_status === 'success') badge.classList.add('bg-green-100', 'text-green-700');
                    else if (data.new_status === 'pending') badge.classList.add('bg-yellow-100', 'text-yellow-700');
                    else badge.classList.add('bg-red-100', 'text-red-700');
                }
            });
        }
    </script>
</x-app-layout>