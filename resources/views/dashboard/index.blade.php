@extends('layouts.app')

@section('title', 'Dashboard Overview')
@section('page-title', 'Operational Intelligence')

@section('content')
<div class="space-y-8 pb-10">

    {{-- 1. DYNAMIC WELCOME BANNER --}}
    <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-200">
        {{-- Animated Background Elements --}}
        <div
            class="absolute top-[-20%] right-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] animate-pulse">
        </div>
        <div class="absolute bottom-[-20%] left-[20%] w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="space-y-4">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-[10px] font-black uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Live System Active
                </div>
                <h2 class="text-4xl font-black tracking-tight leading-tight">
                    <span id="greeting">Selamat Datang</span>, {{ explode(' ', auth()->user()->name)[0] }}!
                </h2>
                <p class="text-slate-400 font-medium max-w-xl leading-relaxed">
                    Sistem ERP Tekstil memantau aliran produksi dan inventaris Anda secara cerdas. Semua data diperbarui
                    secara otomatis.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Real-time Clock Card --}}
                <div class="px-8 py-6 rounded-[2rem] bg-white/5 border border-white/10 backdrop-blur-xl min-w-[200px]">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Waktu Lokal
                        (Real-time)</p>
                    <div class="flex items-baseline gap-2">
                        <span id="real-time-clock"
                            class="text-3xl font-black tabular-nums tracking-tighter">00:00:00</span>
                        <span class="text-sm font-bold text-slate-400">WIB</span>
                    </div>
                </div>
                {{-- Quick Metrics --}}
                <div class="px-8 py-6 rounded-[2rem] bg-emerald-500/10 border border-emerald-500/20 backdrop-blur-xl">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-400 font-black mb-2">Hari Ini</p>
                    <span class="text-xl font-black block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F')
                        }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. KPI CARDS WITH LIVE FEEDBACK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
        $stats = [
        ['label' => 'WO Aktif', 'value' => '24', 'target' => 'wo-active', 'icon' => 'activity', 'color' => 'indigo'],
        ['label' => 'Stok Kritis', 'value' => '8', 'target' => 'stock-alert', 'icon' => 'alert-triangle', 'color' =>
        'rose'],
        ['label' => 'PR Pending', 'value' => '12', 'target' => 'pr-pending', 'icon' => 'shopping-cart', 'color' =>
        'amber'],
        ['label' => 'Total Users', 'value' => '42', 'target' => 'user-count', 'icon' => 'users', 'color' => 'emerald'],
        ];
        @endphp

        @foreach($stats as $stat)
        <div
            class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-[0.03] group-hover:opacity-10 transition-opacity">
                <i data-lucide="{{ $stat['icon'] }}" class="w-24 h-24"></i>
            </div>

            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-12 h-12 rounded-2xl bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-600 group-hover:bg-{{ $stat['color'] }}-600 group-hover:text-white transition-all duration-500 shadow-sm">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                </div>
                <div class="h-px flex-1 bg-slate-50"></div>
            </div>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
            <div class="flex items-baseline gap-2 mt-1">
                <p id="{{ $stat['target'] }}" class="text-4xl font-black text-slate-900 tracking-tighter">{{
                    $stat['value'] }}</p>
                <span
                    class="text-[10px] font-bold text-emerald-500 flex items-center bg-emerald-50 px-2 py-0.5 rounded-full">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> Live
                </span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. MAIN SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Production Efficiency (Real Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 p-10 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Efisiensi Produksi</h3>
                    <p class="text-sm text-slate-400 font-medium">Monitoring output mesin secara real-time</p>
                </div>
                <div class="flex bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                    <button class="px-6 py-2 bg-white rounded-xl shadow-sm text-xs font-black text-slate-900">7
                        Hari</button>
                    <button class="px-6 py-2 text-xs font-bold text-slate-400 hover:text-slate-600">30 Hari</button>
                </div>
            </div>

            {{-- Placeholder for Chart --}}
            <div
                class="relative h-80 w-full bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center group overflow-hidden">
                {{-- Simulated Chart Pattern --}}
                <div class="absolute inset-0 flex items-end justify-around px-10 pb-10 opacity-20">
                    @for($i=1; $i<=7; $i++) <div class="w-12 bg-indigo-500 rounded-t-xl"
                        style="height: {{ rand(30, 90) }}%">
                </div>
                @endfor
            </div>
            <div
                class="relative z-10 flex flex-col items-center text-center p-6 backdrop-blur-sm bg-white/30 rounded-3xl border border-white/50">
                <div
                    class="w-16 h-16 rounded-full bg-white shadow-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i data-lucide="bar-chart" class="w-8 h-8 text-indigo-500"></i>
                </div>
                <p class="text-slate-900 font-black tracking-tight">Chart Engine Ready</p>
                <p class="text-slate-400 text-xs mt-1 font-medium italic">Menunggu koneksi data produksi...</p>
            </div>
        </div>
    </div>

    {{-- Live Activity Log --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 p-10 shadow-sm relative overflow-hidden group">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Live Feed</h3>
            <span class="flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
            </span>
        </div>

        <div class="space-y-8" id="activity-feed">
            {{-- Items --}}
            <div
                class="relative pl-8 before:absolute before:left-0 before:top-1.5 before:w-3 before:h-3 before:bg-indigo-600 before:rounded-full before:ring-4 before:ring-indigo-50">
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Baru Saja</p>
                <p class="text-sm font-bold text-slate-900 mt-0.5">Stock Out: Benang Polyester</p>
                <p class="text-xs text-slate-400 font-medium">Warehouse A — Admin</p>
            </div>

            <div
                class="relative pl-8 before:absolute before:left-0 before:top-1.5 before:w-3 before:h-3 before:bg-emerald-500 before:rounded-full before:ring-4 before:ring-emerald-50">
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">2 Menit Lalu</p>
                <p class="text-sm font-bold text-slate-900 mt-0.5">PR #8821 Approved</p>
                <p class="text-xs text-slate-400 font-medium">Oleh Manager Produksi</p>
            </div>

            <div
                class="relative pl-8 before:absolute before:left-0 before:top-1.5 before:w-3 before:h-3 before:bg-amber-500 before:rounded-full before:ring-4 before:ring-amber-50">
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">15 Menit Lalu</p>
                <p class="text-sm font-bold text-slate-900 mt-0.5">Update Supplier: PT. Textilindo</p>
                <p class="text-xs text-slate-400 font-medium">Sistem sinkronisasi selesai</p>
            </div>
        </div>

        <button
            class="w-full mt-10 py-4 rounded-[1.5rem] bg-slate-50 text-slate-600 text-[11px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            Buka Log Audit
        </button>
    </div>
</div>
</div>

<script>
    // 1. Live Clock Function
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('real-time-clock').textContent = `${hours}:${minutes}:${seconds}`;

        // Update Greeting based on time
        const greetingElement = document.getElementById('greeting');
        if (hours >= 5 && hours < 11) greetingElement.textContent = "Selamat Pagi";
        else if (hours >= 11 && hours < 15) greetingElement.textContent = "Selamat Siang";
        else if (hours >= 15 && hours < 18) greetingElement.textContent = "Selamat Sore";
        else greetingElement.textContent = "Selamat Malam";
    }

    // 2. Simulate Real-time Data Updates
    function updateKPIs() {
        const stats = ['wo-active', 'stock-alert', 'pr-pending'];
        const randomTarget = stats[Math.floor(Math.random() * stats.length)];
        const element = document.getElementById(randomTarget);

        // Add flash effect
        element.classList.add('text-indigo-600', 'scale-110');

        setTimeout(() => {
            element.classList.remove('text-indigo-600', 'scale-110');
        }, 1000);
    }

    // Initialize
    setInterval(updateClock, 1000);
    setInterval(updateKPIs, 5000); // Pulse stats every 5s
    updateClock();
</script>
@endsection