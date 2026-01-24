<x-app-layout>
    <div class=" bg-beach-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: Stat Cards & Tabel --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- STAT CARDS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <a href="{{ route('destinations.index') }}"
                           class="group bg-white rounded-2xl shadow-sm p-6 flex items-center gap-5 border border-transparent hover:border-beach-cyan hover:shadow-xl transition-all duration-300 border-t-4">
                            <div class="p-4 bg-beach-cyan/20 text-beach-blue rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-map-location-dot text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Destinasi</p>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $totalDestinations }}</p>
                            </div>
                        </a>

                        {{-- Ganti card Total Booking yang lama dengan ini --}}
                        <a href="{{ route('transactions.index') }}" 
                        class="group bg-white rounded-2xl shadow-sm p-6 flex items-center gap-5 border border-transparent hover:border-beach-orange hover:shadow-xl transition-all duration-300 border-t-4">
                            <div class="p-4 bg-beach-orange/10 text-beach-orange rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-ticket text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Booking</p>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $chartData->sum('total_booked') }}</p>
                                <p class="text-[10px] text-beach-orange font-bold mt-1 uppercase">Lihat Detail Order &rarr;</p>
                            </div>
                        </a>
                    </div>

                    {{-- TABEL BOOKINGAN TERBARU (TINGGI DITAMBAH) --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col min-h-[650px] hover:border-beach-blue hover:shadow-xl transition-all duration-300 border-t-4"> {{-- Menambah min-height pada box utama --}}
                        <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                            <div>
                                <h3 class="text-lg font-black uppercase tracking-widest text-beach-blue">Bookingan Terbaru</h3>
                                <p class="text-xs text-gray-400 mt-1">Daftar pesanan masuk yang perlu dikelola</p>
                            </div>
                            <div class="flex items-center gap-3 p-2 bg-beach-sand/30 rounded-3xl border border-beach-sand">
                                {{-- Label Sederhana --}}

                                {{-- Tombol PDF --}}
                            <a href="javascript:void(0)" 
                            onclick="confirmExport('{{ route('admin.export-pdf') }}', 'PDF')"
                            class="flex items-center gap-2 bg-white hover:bg-beach-blue text-beach-blue hover:text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 shadow-sm border border-beach-sand/50 group">
                                <i class="fa-solid fa-file-pdf text-red-500 group-hover:text-white transition-colors"></i>
                                <span>PDF</span>
                            </a>

                            {{-- Tombol Word --}}
                            <a href="javascript:void(0)" 
                            onclick="confirmExport('{{ route('admin.export-word') }}', 'Word')"
                            class="flex items-center gap-2 bg-white hover:bg-blue-600 text-blue-600 hover:text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 shadow-sm border border-beach-sand/50 group">
                                <i class="fa-solid fa-file-word text-blue-500 group-hover:text-white transition-colors"></i>
                                <span>Word</span>
                            </a>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto flex-grow"> {{-- flex-grow agar tabel mengisi ruang yang tersedia --}}
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-8 py-6 text-left text-sm font-bold text-gray-500 uppercase tracking-wide">Destinasi Wisata</th>
                                        <th class="px-8 py-6 text-left text-sm font-bold text-gray-500 uppercase tracking-wide">Total</th>
                                        <th class="px-8 py-6 text-center text-sm font-bold text-gray-500 uppercase tracking-wide">Status</th>
                                        <th class="px-8 py-6 text-right text-sm font-bold text-gray-500 uppercase tracking-wide">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($recentTransactions as $trx)
                                    <tr class="hover:bg-beach-sand/20 transition-all duration-200 group">
                                        {{-- Nama Destinasi - Tinggi ditambah dengan py-8 --}}
                                        <td class="px-8 py-8">
                                            <div class="flex items-center gap-4">
                                                <div class="w-1.5 h-10 bg-beach-cyan rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                                                <div>
                                                    <span class="text-base font-bold text-gray-800 block">{{ $trx->destination->name }}</span>
                                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">ID: #TRX-{{ $trx->id }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Harga/Total --}}
                                        <td class="px-8 py-8 text-base font-black text-beach-blue">
                                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                        </td>
                                        
                                        {{-- Badge Status --}}
                                        <td class="px-8 py-8 text-center">
                                            <span id="status-badge-{{ $trx->id }}" 
                                                class="px-6 py-2.5 text-xs font-black uppercase rounded-full shadow-sm transition-all duration-300
                                                {{ $trx->status == 'success' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $trx->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $trx->status == 'cancel' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ $trx->status }}
                                            </span>
                                        </td>

                                        {{-- Tombol Pilihan --}}
                                        <td class="px-8 py-8 text-right relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false" 
                                                    class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-400 hover:bg-beach-blue hover:text-white transition-all flex items-center justify-center border border-gray-100 mx-auto mr-0">
                                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                            </button>

                                            {{-- Dropdown --}}
                                            <div x-show="open" 
                                                x-transition:enter="transition ease-out duration-100"
                                                class="absolute right-8 mt-4 w-48 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden text-left"
                                                style="display: none;">
                                                <button @click="updateStatus({{ $trx->id }}, 'success'); open = false" class="w-full px-6 py-4 text-xs font-bold text-green-600 hover:bg-green-50 transition flex items-center gap-3"><i class="fa-solid fa-check-circle"></i> Success</button>
                                                <button @click="updateStatus({{ $trx->id }}, 'pending'); open = false" class="w-full px-6 py-4 text-xs font-bold text-yellow-600 hover:bg-yellow-50 transition border-y border-gray-50 flex items-center gap-3"><i class="fa-solid fa-clock"></i> Pending</button>
                                                <button @click="updateStatus({{ $trx->id }}, 'cancel'); open = false" class="w-full px-6 py-4 text-xs font-bold text-red-600 hover:bg-red-50 transition flex items-center gap-3"><i class="fa-solid fa-times-circle"></i> Cancel</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="px-8 py-32 text-center text-gray-400 italic font-medium">Belum ada transaksi masuk untuk saat ini.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Grafik Pendapatan --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-8 hover:border-beach-cyan hover:shadow-xl transition-all duration-300 border-t-4">
                        <div class="p-6 border-b border-gray-50 bg-white text-center">
                            <h3 class="text-sm font-black uppercase tracking-widest text-beach-blue">Pendapatan Mingguan</h3>
                            <p class="text-[10px] text-gray-400 mt-1">Bulan {{ date('F Y') }}</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="relative h-80 w-full">
                                <canvas id="incomeChart"></canvas>
                            </div>
                        </div>

                        <div class="p-4 bg-beach-cyan/10 border-t border-gray-50 text-center">
                            <p class="text-[10px] font-bold text-beach-blue uppercase mb-1">Total Bulan Ini</p>
                            <p class="text-xl font-black text-beach-blue">Rp {{ number_format($values->sum(), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fungsi Update Status AJAX
        function updateStatus(id, nextStatus) {
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
                    const badge = document.getElementById(`status-badge-${id}`);
                    badge.innerText = data.new_status;
                    
                    // Reset class warna
                    badge.className = 'px-3 py-1 text-[10px] font-black uppercase rounded-full transition-all duration-300 ';
                    
                    if (data.new_status === 'success') badge.classList.add('bg-green-100', 'text-green-700');
                    else if (data.new_status === 'pending') badge.classList.add('bg-yellow-100', 'text-yellow-700');
                    else if (data.new_status === 'cancel') badge.classList.add('bg-red-100', 'text-red-700');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Grafik Chart.js
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('incomeChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(115, 200, 210, 0.4)');
            gradient.addColorStop(1, 'rgba(115, 200, 210, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Pendapatan',
                        data: {!! json_encode($values) !!},
                        borderColor: '#73c8d2',
                        backgroundColor: gradient,
                        fill: true,
                        borderWidth: 4,
                        tension: 0.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#73c8d2',
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#0046ff',
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
                                    return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: { display: false, beginAtZero: true },
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#73c8d2', font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
    <script>
function confirmExport(url, type) {
    Swal.fire({
        title: 'Ekspor Data?',
        text: `Sistem akan menyiapkan file ${type} untuk laporan ini.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0ea5e9', // Warna Beach Blue/Cyan
        cancelButtonColor: '#94a3b8', // Warna Gray
        confirmButtonText: 'Ya, Download!',
        cancelButtonText: 'Batal',
        border: 'none',
        borderRadius: '2rem',
        customClass: {
            popup: 'rounded-[2rem]', // Menyesuaikan dengan gaya rounded-3xl Anda
            confirmButton: 'rounded-xl font-black uppercase tracking-widest text-[10px] px-6 py-3',
            cancelButton: 'rounded-xl font-black uppercase tracking-widest text-[10px] px-6 py-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading sebentar sebelum download
            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu sebentar.',
                timer: 2000,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Arahkan ke rute export
            window.location.href = url;
        }
    })
}
</script>
</x-app-layout>