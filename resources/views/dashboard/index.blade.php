@extends('layouts.app')

@section('title', 'Dashboard Overview')
@section('page-title', 'Operational Intelligence')

@section('content')
<div class="space-y-8 pb-10">

    {{-- 1. DYNAMIC WELCOME BANNER --}}
    <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-200">
        <div class="absolute top-[-20%] right-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-[10px] font-black uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Live System Active
                </div>
                <h2 class="text-4xl font-black tracking-tight leading-tight">
                    <span id="greeting">Selamat Datang</span>, {{ explode(' ', auth()->user()->name)[0] }}!
                </h2>
                <p class="text-slate-400 font-medium max-w-xl leading-relaxed">
                    Sistem ERP Tekstil memantau aliran produksi dan inventaris Anda secara cerdas.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <div class="px-8 py-6 rounded-[2rem] bg-white/5 border border-white/10 backdrop-blur-xl min-w-[200px]">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Waktu Lokal</p>
                    <div class="flex items-baseline gap-2">
                        <span id="real-time-clock" class="text-3xl font-black tabular-nums tracking-tighter">00:00:00</span>
                        <span class="text-sm font-bold text-slate-400">WIB</span>
                    </div>
                </div>
                <div class="px-8 py-6 rounded-[2rem] bg-emerald-500/10 border border-emerald-500/20 backdrop-blur-xl">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-400 font-black mb-2">Hari Ini</p>
                    <span class="text-xl font-black block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. KPI CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Produk', 'value' => $totalProducts, 'target' => 'total-products', 'icon' => 'package', 'colorClass' => 'text-indigo-600', 'bgClass' => 'bg-indigo-50', 'hoverClass' => 'group-hover:bg-indigo-600'],
                ['label' => 'Stok Kritis', 'value' => $stockAlertCount, 'target' => 'stock-alert', 'icon' => 'alert-triangle', 'colorClass' => 'text-rose-600', 'bgClass' => 'bg-rose-50', 'hoverClass' => 'group-hover:bg-rose-600'],
                ['label' => 'Kategori', 'value' => $totalCategories, 'target' => 'cat-count', 'icon' => 'layers', 'colorClass' => 'text-amber-600', 'bgClass' => 'bg-amber-50', 'hoverClass' => 'group-hover:bg-amber-600'],
                ['label' => 'Total Users', 'value' => $totalUsers, 'target' => 'user-count', 'icon' => 'users', 'colorClass' => 'text-emerald-600', 'bgClass' => 'bg-emerald-50', 'hoverClass' => 'group-hover:bg-emerald-600'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-[0.03] group-hover:opacity-10 transition-opacity">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-24 h-24"></i>
                </div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl {{ $stat['bgClass'] }} flex items-center justify-center {{ $stat['colorClass'] }} {{ $stat['hoverClass'] }} group-hover:text-white transition-all duration-500 shadow-sm">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    <div class="h-px flex-1 bg-slate-50"></div>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p id="{{ $stat['target'] }}" class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stat['value'] }}</p>
                    <span class="text-[10px] font-bold text-emerald-500 flex items-center bg-emerald-50 px-2 py-0.5 rounded-full">
                        <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> Real
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 3. MAIN SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Production Chart --}}
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 p-10 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Katalog Growth</h3>
                    <p class="text-sm text-slate-400 font-medium">Penambahan produk dalam 7 hari terakhir</p>
                </div>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="productionChart"></canvas>
            </div>
        </div>

        {{-- Live Activity Feed --}}
        <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Recent Products</h3>
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
            </div>

            <div class="space-y-8" id="activity-feed">
                @forelse($recentActivities as $activity)
                <div class="relative pl-8 before:absolute before:left-0 before:top-1.5 before:w-3 before:h-3 before:bg-indigo-600 before:rounded-full before:ring-4 before:ring-indigo-50">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $activity->created_at->diffForHumans() }}</p>
                    <p class="text-sm font-bold text-slate-900 mt-0.5 truncate">{{ $activity->name }}</p>
                    <p class="text-xs text-slate-400 font-medium italic">Added to {{ $activity->category->name ?? 'General' }}</p>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>

            <a href="{{ route('products.index') }}" class="block w-full text-center mt-10 py-4 rounded-[1.5rem] bg-slate-50 text-slate-600 text-[11px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 hover:text-white transition-all">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Clock
        function updateClock() {
            const now = new Date();
            const clock = document.getElementById('real-time-clock');
            if (clock) clock.textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Real Data Chart
        const ctx = document.getElementById('productionChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Produk Baru',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#4f46e5',
                    borderWidth: 4,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        lucide.createIcons();
    });
</script>
@endsection