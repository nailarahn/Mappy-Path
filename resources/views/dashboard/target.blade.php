{{-- ============================================================
     target.blade.php
     Halaman utama Target Belajar Mingguan (Mappy Path)
     Layout: sidebar kiri + konten kanan
     Fitur:
       - Tampilan kosong (empty state) saat belum ada target
       - Daftar "Target Aktif" setelah target disimpan
       - Tombol Tambah Target → redirect/show form
       - Tombol Edit (ikon pensil) → buka form edit
       - Tombol Hapus (ikon tong) → konfirmasi lalu delete
       - Progress bar animasi
       - Fully responsive (mobile sidebar collapsible)
     ============================================================ --}}

@extends('layouts.app')   {{-- sesuaikan dengan layout utama proyekmu --}}

@section('title', 'Target Belajar Mingguan')

@push('styles')
<style>
  /* ─── Google Fonts ─── */
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

  /* ─── CSS Variables ─── */
  :root {
    --primary: #6c3fc5;
    --primary-dark: #5a2fa8;
    --primary-light: #ede9fb;
    --sidebar-bg: #ece9f8;
    --sidebar-active: #5a2fa8;
    --danger: #e53935;
    --success: #22c55e;
    --warning: #f59e0b;
    --text-main: #1a1a2e;
    --text-muted: #9399a6;
    --card-bg: #ffffff;
    --page-bg: #f7f6fd;
    --border: #e5e7eb;
    --radius: 14px;
    --sidebar-w: 280px;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--page-bg);
    color: var(--text-main);
    min-height: 100vh;
    display: flex;
  }

  /* ═══════════════ SIDEBAR ═══════════════ */
  .sidebar {
    width: var(--sidebar-w);
    background: var(--sidebar-bg);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 28px 20px;
    position: fixed;
    top: 0; left: 0;
    transition: transform .3s ease;
    z-index: 100;
  }

  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 40px;
  }

  .sidebar-logo-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #7c4dff, #5a2fa8);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
  }

  .sidebar-logo span {
    font-size: 20px; font-weight: 800;
    color: var(--text-main);
  }

  .sidebar-nav { flex: 1; display: flex; flex-direction: column; gap: 4px; }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    color: #555;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: background .2s, color .2s, transform .15s;
  }

  .nav-item:hover {
    background: rgba(108,63,197,.12);
    color: var(--primary);
    transform: translateX(3px);
  }

  .nav-item.active {
    background: var(--sidebar-active);
    color: #fff;
  }

  .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

  .sidebar-bottom {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding-top: 16px;
    border-top: 1px solid rgba(0,0,0,.08);
  }

  .nav-item.danger { color: var(--danger); }
  .nav-item.danger:hover { background: #fce4e4; }

  /* ─── Hamburger (mobile) ─── */
  .hamburger {
    display: none;
    position: fixed;
    top: 18px; left: 16px;
    z-index: 200;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 8px 10px;
    cursor: pointer;
    font-size: 18px;
  }

  .sidebar-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.4);
    z-index: 90;
  }

  /* ═══════════════ MAIN CONTENT ═══════════════ */
  .main {
    margin-left: var(--sidebar-w);
    flex: 1;
    padding: 48px 56px;
    max-width: 100%;
  }

  .page-header { margin-bottom: 36px; }

  .page-header h1 {
    font-size: 32px; font-weight: 800;
    color: var(--text-main);
    line-height: 1.2;
  }

  .page-header p {
    color: var(--text-muted);
    font-size: 15px;
    margin-top: 6px;
  }

  /* ─── Add Button ─── */
  .btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #7c4dff, #5a2fa8);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 18px rgba(108,63,197,.35);
    margin-bottom: 32px;
  }

  .btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(108,63,197,.45);
  }

  .btn-add:active { transform: translateY(0); }

  /* ═══════════════ EMPTY STATE ═══════════════ */
  .empty-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px dashed var(--border);
    padding: 72px 40px;
    text-align: center;
    animation: fadeInUp .5s ease;
  }

  .empty-icon {
    width: 80px; height: 80px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    animation: pulse 2.5s infinite;
  }

  .empty-icon svg { width: 38px; height: 38px; color: var(--primary); }

  .empty-card h3 {
    font-size: 20px; font-weight: 700;
    margin-bottom: 10px;
  }

  .empty-card p {
    color: var(--text-muted);
    font-size: 14px;
    max-width: 340px;
    margin: 0 auto;
    line-height: 1.6;
  }

  /* ═══════════════ TARGET LIST ═══════════════ */
  .section-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 16px;
    color: var(--text-main);
  }

  .targets-grid { display: flex; flex-direction: column; gap: 16px; }

  /* ─── Target Card ─── */
  .target-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    padding: 20px 24px;
    animation: fadeInUp .4s ease;
    transition: box-shadow .25s, transform .25s;
  }

  .target-card:hover {
    box-shadow: 0 8px 28px rgba(108,63,197,.12);
    transform: translateY(-2px);
  }

  .target-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 18px;
  }

  .target-card-info { display: flex; align-items: center; gap: 14px; }

  .target-icon {
    width: 52px; height: 52px;
    background: var(--primary-light);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .target-icon svg { width: 26px; height: 26px; color: var(--primary); }

  .target-meta h4 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 4px;
  }

  .target-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-muted);
  }

  .target-date svg { width: 14px; height: 14px; }

  .target-actions { display: flex; gap: 8px; }

  .btn-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    border: 1.5px solid var(--border);
    background: transparent;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s;
    color: #888;
  }

  .btn-icon:hover.edit-btn { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }
  .btn-icon:hover.delete-btn { background: #fce4e4; color: var(--danger); border-color: var(--danger); }

  .btn-icon svg { width: 16px; height: 16px; }

  /* ─── Stats Row ─── */
  .stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 16px;
  }

  .stat-box {
    background: #f8f8fb;
    border-radius: 10px;
    padding: 14px;
    text-align: center;
  }

  .stat-box .stat-val {
    font-size: 24px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-box .stat-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
  }

  .stat-val.purple { color: var(--primary); }
  .stat-val.blue   { color: #3b82f6; }
  .stat-val.green  { color: var(--success); }

  /* ─── Progress Bar ─── */
  .progress-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
  }

  .progress-row span { font-size: 13px; font-weight: 600; color: var(--text-muted); }

  .progress-track {
    width: 100%;
    height: 8px;
    background: #ece9f8;
    border-radius: 99px;
    overflow: hidden;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #7c4dff, #5a2fa8);
    border-radius: 99px;
    width: 0%;
    transition: width 1.2s cubic-bezier(.4,0,.2,1);
  }

  /* ═══════════════ DELETE MODAL ═══════════════ */
  .modal-backdrop {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 300;
    align-items: center;
    justify-content: center;
  }

  .modal-backdrop.open { display: flex; animation: fadeIn .2s; }

  .modal-box {
    background: #fff;
    border-radius: 18px;
    padding: 32px;
    max-width: 380px;
    width: 90%;
    text-align: center;
    animation: scaleIn .25s ease;
    box-shadow: 0 24px 60px rgba(0,0,0,.18);
  }

  .modal-icon {
    width: 60px; height: 60px;
    background: #fce4e4;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    font-size: 26px;
  }

  .modal-box h3 { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
  .modal-box p  { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; line-height: 1.6; }

  .modal-actions { display: flex; gap: 10px; }

  .btn-cancel, .btn-delete {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: transform .15s, box-shadow .15s;
  }

  .btn-cancel  { background: #f3f4f6; color: #555; }
  .btn-delete  { background: var(--danger); color: #fff; }

  .btn-cancel:hover  { background: #e5e7eb; }
  .btn-delete:hover  { transform: scale(1.02); box-shadow: 0 4px 16px rgba(229,57,53,.35); }

  /* ─── Toast ─── */
  .toast {
    position: fixed;
    bottom: 24px; right: 24px;
    background: #1a1a2e;
    color: #fff;
    padding: 14px 22px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    display: flex; align-items: center; gap: 10px;
    z-index: 999;
    transform: translateY(80px);
    opacity: 0;
    transition: all .35s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
  }

  .toast.show { transform: translateY(0); opacity: 1; }
  .toast.success { background: var(--primary); }
  .toast.error   { background: var(--danger); }

  /* ═══════════════ ANIMATIONS ═══════════════ */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

  @keyframes scaleIn {
    from { opacity: 0; transform: scale(.9); }
    to   { opacity: 1; transform: scale(1); }
  }

  @keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(108,63,197,.3); }
    50%       { box-shadow: 0 0 0 12px rgba(108,63,197,0); }
  }

  /* ═══════════════ RESPONSIVE ═══════════════ */
  @media (max-width: 900px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .sidebar-overlay.open { display: block; }
    .hamburger { display: block; }
    .main { margin-left: 0; padding: 80px 20px 40px; }
    .stats-row { grid-template-columns: repeat(3,1fr); }
  }

  @media (max-width: 560px) {
    .page-header h1 { font-size: 24px; }
    .stats-row { grid-template-columns: repeat(3,1fr); gap: 6px; }
    .stat-box { padding: 10px 6px; }
    .stat-box .stat-val { font-size: 20px; }
    .target-card { padding: 14px 16px; }
    .main { padding: 72px 14px 32px; }
  }
</style>
@endpush

@section('content')

<!-- ─── Hamburger (mobile) ─── -->
<button class="hamburger" id="hamburgerBtn" aria-label="Menu">&#9776;</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ════════════════════════════════════
     SIDEBAR
════════════════════════════════════ -->
<aside class="sidebar" id="sidebar">

  <!-- Logo -->
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon">📖</div>
    <span>Mappy Path</span>
  </div>

  <!-- Navigation -->
  <nav class="sidebar-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
      </svg>
      Dashboard
    </a>

    <a href="{{ route('roadmap.index') }}" class="nav-item {{ request()->routeIs('roadmap.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6-10l6-3m6 3l-6 3m6-3v10.382a1 1 0 01-.553.894L15 20m0-13v13"/>
      </svg>
      Roadmap
    </a>

    <a href="{{ route('target.index') }}" class="nav-item {{ request()->routeIs('target.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
      </svg>
      Target Belajar
    </a>

    <a href="{{ route('progress.index') }}" class="nav-item {{ request()->routeIs('progress.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
      </svg>
      Progress
    </a>
  </nav>

  <!-- Bottom items -->
  <div class="sidebar-bottom">
    <a href="{{ route('settings') }}" class="nav-item">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
      </svg>
      Pengaturan
    </a>

    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="nav-item danger" style="width:100%;text-align:left;background:none;border:none;font-family:inherit;font-size:15px;cursor:pointer">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Keluar
      </button>
    </form>
  </div>
</aside>

<!-- ════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════ -->
<main class="main">

  <!-- Header -->
  <div class="page-header">
    <h1>Target Belajar Mingguan</h1>
    <p>Tentukan apa yang ingin kamu capai minggu ini</p>
  </div>

  <!-- Flash messages -->
  @if(session('success'))
    <div id="flashMsg" data-msg="{{ session('success') }}" data-type="success"></div>
  @endif
  @if(session('error'))
    <div id="flashMsg" data-msg="{{ session('error') }}" data-type="error"></div>
  @endif

  <!-- Add Button -->
  <a href="{{ route('target.create') }}" class="btn-add">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" width="18" height="18">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah Target
  </a>

  {{-- ─── Empty State ─── --}}
  @if($targets->isEmpty())
    <div class="empty-card">
      <div class="empty-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
        </svg>
      </div>
      <h3>Belum Ada Target Minggu ini</h3>
      <p>Atur target pertamamu di atas untuk memulai perjalanan belajar minggu ini</p>
    </div>

  {{-- ─── Target List ─── --}}
  @else
    <p class="section-title">Target Aktif</p>

    <div class="targets-grid">
      @foreach($targets as $target)
        @php
          $pct  = $target->target > 0 ? round(($target->selesai / $target->target) * 100) : 0;
          $sisa = max(0, $target->target - $target->selesai);
        @endphp

        <div class="target-card" data-id="{{ $target->id }}">

          <!-- Header: icon + info + actions -->
          <div class="target-card-header">
            <div class="target-card-info">
              <div class="target-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                  <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                </svg>
              </div>
              <div class="target-meta">
                <h4>{{ $target->jenis }} {{ $target->target }} {{ Str::lower($target->jenis) === 'menyelesaikan materi' ? 'Materi' : 'Item' }}</h4>
                <div class="target-date">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                  </svg>
                  {{ \Carbon\Carbon::parse($target->mulai)->format('j M') }} –
                  {{ \Carbon\Carbon::parse($target->selesai_tanggal)->format('j M Y') }}
                </div>
              </div>
            </div>

            <!-- Edit & Delete -->
            <div class="target-actions">
              <a href="{{ route('target.edit', $target->id) }}" class="btn-icon edit-btn" title="Edit">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
              </a>
              <button class="btn-icon delete-btn"
                      onclick="confirmDelete({{ $target->id }}, '{{ addslashes($target->jenis) }}')"
                      title="Hapus">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                  <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
              </button>
            </div>
          </div><!-- /target-card-header -->

          <!-- Stats -->
          <div class="stats-row">
            <div class="stat-box">
              <div class="stat-val purple">{{ $target->target }}</div>
              <div class="stat-label">Target</div>
            </div>
            <div class="stat-box">
              <div class="stat-val blue">{{ $target->selesai }}</div>
              <div class="stat-label">Selesai</div>
            </div>
            <div class="stat-box">
              <div class="stat-val green">{{ $sisa }}</div>
              <div class="stat-label">Tersisa</div>
            </div>
          </div>

          <!-- Progress -->
          <div class="progress-row">
            <span>Progress</span>
            <span class="pct-label">{{ $pct }}%</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill" data-pct="{{ $pct }}"></div>
          </div>

        </div><!-- /target-card -->
      @endforeach
    </div><!-- /targets-grid -->
  @endif

</main><!-- /main -->

<!-- ═══════ DELETE MODAL ═══════ -->
<div class="modal-backdrop" id="deleteModal">
  <div class="modal-box">
    <div class="modal-icon">🗑️</div>
    <h3>Hapus Target?</h3>
    <p id="deleteModalText">Kamu yakin ingin menghapus target ini? Tindakan ini tidak bisa dibatalkan.</p>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal()">Batal</button>
      <form id="deleteForm" method="POST" style="flex:1">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete" style="width:100%">Hapus</button>
      </form>
    </div>
  </div>
</div>

<!-- ─── Toast ─── -->
<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
  // ─── Sidebar toggle (mobile) ───
  const sidebar  = document.getElementById('sidebar');
  const overlay  = document.getElementById('sidebarOverlay');
  const hamburger = document.getElementById('hamburgerBtn');

  hamburger?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
  });
  overlay?.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
  });

  // ─── Animate progress bars on load ───
  window.addEventListener('load', () => {
    document.querySelectorAll('.progress-fill').forEach(bar => {
      const pct = bar.dataset.pct;
      setTimeout(() => { bar.style.width = pct + '%'; }, 200);
    });
  });

  // ─── Delete modal ───
  let pendingDeleteId = null;

  function confirmDelete(id, label) {
    pendingDeleteId = id;
    document.getElementById('deleteModalText').textContent =
      `Kamu yakin ingin menghapus target "${label}"? Tindakan ini tidak bisa dibatalkan.`;
    document.getElementById('deleteForm').action = `/target/${id}`;
    document.getElementById('deleteModal').classList.add('open');
  }

  function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
  }

  // close modal on backdrop click
  document.getElementById('deleteModal').addEventListener('click', function(e){
    if (e.target === this) closeModal();
  });

  // ─── Toast from session flash ───
  const flashEl = document.getElementById('flashMsg');
  if (flashEl) {
    showToast(flashEl.dataset.msg, flashEl.dataset.type);
  }

  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    t.className = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3500);
  }
</script>
@endpush