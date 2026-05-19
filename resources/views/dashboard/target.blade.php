@extends('layouts.dashboard')
@section('title', 'Target Belajar')
@push('styles')
<style>
.page-title { font-size:1.5rem; font-weight:800; color:var(--primary); margin-bottom:1.75rem; }
.target-list { display:flex; flex-direction:column; gap:1rem; }
.target-card {
    background:var(--white);
    border-radius:var(--radius);
    border:1.5px solid var(--gray-200);
    padding:1.25rem 1.5rem;
    display:flex;
    align-items:center;
    gap:1.25rem;
    transition:all 0.2s;
    flex-wrap:wrap;
}
.target-card:hover { box-shadow:0 6px 20px rgba(55,36,102,0.08); }
.target-icon { font-size:1.6rem; flex-shrink:0; }
.target-info { flex:1; min-width:200px; }
.target-name { font-size:.95rem; font-weight:700; color:var(--gray-800); margin-bottom:.25rem; }
.target-deadline { font-size:.78rem; color:var(--gray-400); }
.target-progress { min-width:200px; flex:1; }
.target-pct-row { display:flex; justify-content:space-between; margin-bottom:.35rem; font-size:.8rem; font-weight:600; }
.target-pct-row .pct { color:var(--primary); }
.status-badge {
    padding:.3rem .85rem;
    border-radius:50px;
    font-size:.75rem;
    font-weight:700;
    flex-shrink:0;
}
.status-active { background:#ede9ff; color:var(--primary); }
.status-done { background:#ecfdf5; color:#16a34a; }
</style>
@endpush
@section('content')
<div class="page-title">🎯 Target Belajar</div>
<div class="target-list">
    @foreach($targets as $t)
    <div class="target-card">
        <div class="target-icon">{{ $t['status'] === 'done' ? '✅' : '🎯' }}</div>
        <div class="target-info">
            <div class="target-name">{{ $t['name'] }}</div>
            <div class="target-deadline">📅 Deadline: {{ $t['deadline'] }}</div>
        </div>
        <div class="target-progress">
            <div class="target-pct-row">
                <span>Progress</span>
                <span class="pct">{{ min($t['progress'],100) }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:{{ min($t['progress'],100) }}%"></div>
            </div>
        </div>
        <span class="status-badge status-{{ $t['status'] }}">
            {{ $t['status'] === 'done' ? '🏆 Selesai' : '🔵 Aktif' }}
        </span>
    </div>
    @endforeach
</div>
@endsection