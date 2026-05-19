@extends('layouts.dashboard')

@section('title', 'Roadmap')

@push('styles')
<style>
.page-title { font-size:1.5rem; font-weight:800; color:var(--primary); margin-bottom:1.75rem; }
.roadmap-list { display:flex; flex-direction:column; gap:1.25rem; }

.roadmap-card {
    background:var(--white);
    border-radius:var(--radius);
    border:1.5px solid var(--gray-200);
    padding:1.5rem;
    transition:all 0.2s;
}

.roadmap-card:hover { box-shadow:0 8px 30px rgba(55,36,102,0.1); }
.roadmap-card.active-card { border-color:var(--primary); }

.rmap-header {
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:1rem;
    margin-bottom:1rem;
    flex-wrap:wrap;
}

.rmap-title { font-size:1.1rem; font-weight:700; color:var(--gray-800); }

.rmap-badge {
    padding:.3rem .9rem;
    border-radius:50px;
    font-size:.75rem;
    font-weight:700;
}

.badge-active { background:#ede9ff; color:var(--primary); }
.badge-upcoming { background:#fff7ed; color:#d97706; }
.badge-locked { background:var(--gray-100); color:var(--gray-400); }

.rmap-meta { font-size:.82rem; color:var(--gray-400); margin-bottom:.75rem; }

.rmap-progress-row { display:flex; align-items:center; gap:1rem; margin-bottom:1rem; }

.rmap-pct { font-size:.85rem; font-weight:700; color:var(--primary); min-width:36px; }

/* TAMBAHAN BIAR PROGRESS BAR MUNCUL */
.progress-bar {
    width:100%;
    height:8px;
    background:#e5e7eb;
    border-radius:10px;
    overflow:hidden;
}

.progress-fill {
    height:100%;
    background:var(--primary);
    transition:width 0.3s ease;
}

.stages-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(180px, 1fr));
    gap:.5rem;
    margin-top:1rem;
    padding-top:1rem;
    border-top:1px solid var(--gray-200);
}

.stage-item {
    display:flex;
    align-items:center;
    gap:.5rem;
    font-size:.8rem;
    color:var(--gray-500);
    padding:.35rem .5rem;
    border-radius:8px;
}

.stage-item.done { color:var(--primary); font-weight:500; }

.stage-check {
    width:20px;
    height:20px;
    border-radius:50%;
    border:2px solid var(--gray-300);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:.7rem;
    flex-shrink:0;
}

.stage-check.checked {
    background:var(--primary);
    border-color:var(--primary);
    color:white;
}
</style>
@endpush

@section('content')

<div class="page-title">🗺️ Roadmap Belajar</div>

<div class="roadmap-list">

    {{-- LOOP AMAN (ANTI ERROR) --}}
    @forelse($roadmaps ?? [] as $rm)

    <div class="roadmap-card {{ ($rm['status'] ?? '') === 'active' ? 'active-card' : '' }}">

        <div class="rmap-header">
            <div class="rmap-title">{{ $rm['title'] ?? '-' }}</div>

            <span class="rmap-badge badge-{{ $rm['status'] ?? 'locked' }}">
                @if(($rm['status'] ?? '') === 'active')
                    🟢 Sedang Belajar
                @elseif(($rm['status'] ?? '') === 'upcoming')
                    🟡 Belum Dimulai
                @else
                    🔒 Terkunci
                @endif
            </span>
        </div>

        <div class="rmap-meta">
            {{ $rm['done'] ?? 0 }}/{{ $rm['total'] ?? 0 }} tahap selesai
        </div>

        <div class="rmap-progress-row">
            <div style="flex:1;">
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $rm['progress'] ?? 0 }}%"></div>
                </div>
            </div>
            <div class="rmap-pct">{{ $rm['progress'] ?? 0 }}%</div>
        </div>

        @if(!empty($rm['stages']))
        <div class="stages-grid">

            @foreach($rm['stages'] as $stage)
            <div class="stage-item {{ !empty($stage['done']) ? 'done' : '' }}">
                <div class="stage-check {{ !empty($stage['done']) ? 'checked' : '' }}">
                    {{ !empty($stage['done']) ? '✓' : '' }}
                </div>
                {{ $stage['name'] ?? '-' }}
            </div>
            @endforeach

        </div>
        @endif

    </div>

    @empty
        <p>Tidak ada roadmap tersedia.</p>
    @endforelse

</div>

@endsection