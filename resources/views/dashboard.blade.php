<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-beach-blue leading-tight">
            {{ __('Dashboard Statistik') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-beach-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- STAT CARDS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <a href="{{ route('destinations.index') }}"
                           class="group bg-white rounded-2xl shadow-sm p-6 flex items-center gap-5 border border-transparent hover:border-beach-cyan hover:shadow-xl transition-all duration-300">
                            <div class="p-4 bg-beach-cyan/20 text-beach-blue rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-map-location-dot text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Destinasi</p>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $totalDestinations }}</p>
                            </div>
                        </a>

                        <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-5 border-t-4 border-beach-orange">
                            <div class="p-4 bg-beach-orange/10 text-beach-orange rounded-xl">
                                <i class="fa-solid fa-ticket text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Booking</p>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $chartData->sum('total_booked') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- TABEL TRANSAKSI TERBARU --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                            <h3 class="text-sm font-black uppercase tracking-widest text-beach-blue">Bookingan Terbaru</h3>
                            <i class="fa-solid fa-clock-rotate-left text-gray-300"></i>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Destinasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($recentTransactions as $trx) {{-- Pastikan variabel ini dikirim dari controller --}}
                                    <tr class="hover:bg-beach-sand/10 transition-colors">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $trx->destination->name }}</td>
                                        <td class="px-6 py-4">
                                            {{-- Tombol Status yang bisa diklik --}}
                                            <button onclick="toggleStatus({{ $trx->id }}, '{{ $trx->status }}')" 
                                                    id="status-btn-{{ $trx->id }}"
                                                    class="px-3 py-1 text-[10px] font-black uppercase rounded-full transition-all duration-300
                                                    {{ $trx->status == 'success' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $trx->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $trx->status == 'cancel' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ $trx->status }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-black text-beach-blue">
                                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada transaksi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                        <div class="p-6 border-b border-gray-50 bg-white">
                            <h3 class="text-sm font-black uppercase tracking-widest text-beach-blue text-center">Pendapatan Mingguan</h3>
                            <p class="text-[10px] text-gray-400 text-center mt-1">Bulan {{ date('F Y') }}</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="relative h-80 w-full">
                                <canvas id="incomeChart"></canvas>
                            </div>
                        </div>

                        <div class="p-4 bg-beach-cyan/10 border-t border-gray-50">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-beach-blue uppercase">Total Bulan Ini:</span>
                                <span class="text-sm font-black text-beach-blue">Rp {{ number_format($values->sum(), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('incomeChart').getContext('2d');
                        
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(115, 200, 210, 0.4)'); // Theme Cyan
                        gradient.addColorStop(1, 'rgba(115, 200, 210, 0)');

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($labels) !!},
                                datasets: [{
                                    label: 'Pendapatan',
                                    data: {!! json_encode($values) !!},
                                    borderColor: '#73c8d2', // Cyan
                                    backgroundColor: gradient,
                                    fill: true,
                                    borderWidth: 4,
                                    tension: 0.5,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: '#73c8d2',
                                    pointHoverRadius: 7,
                                    pointHoverBackgroundColor: '#0046ff', // Blue Hover
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        padding: 12,
                                        callbacks: {
                                            label: function(context) {
                                                let value = context.raw;
                                                return ' Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: { 
                                        display: false, 
                                        beginAtZero: true 
                                    },
                                    x: { 
                                        grid: { display: false },
                                        ticks: { color: '#73c8d2', font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                    });

                    function toggleStatus(id, currentStatus) {
                        // Logika rotasi status: pending -> success -> cancel -> pending
                        let nextStatus;
                        if (currentStatus === 'pending') nextStatus = 'success';
                        else if (currentStatus === 'success') nextStatus = 'cancel';
                        else nextStatus = 'pending';

                        fetch(`/transactions/${id}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ status: nextStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const btn = document.getElementById(`status-btn-${id}`);
                                btn.innerText = data.new_status;
                                
                                // Update warna tombol secara dinamis
                                btn.className = 'px-3 py-1 text-[10px] font-black uppercase rounded-full transition-all duration-300 ';
                                if (data.new_status === 'success') btn.classList.add('bg-green-100', 'text-green-700');
                                else if (data.new_status === 'pending') btn.classList.add('bg-yellow-100', 'text-yellow-700');
                                else btn.classList.add('bg-red-100', 'text-red-700');
                                
                                // Update onclick untuk urutan berikutnya
                                btn.setAttribute('onclick', `toggleStatus(${id}, '${data.new_status}')`);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                </script>
</x-app-layout>