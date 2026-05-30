{{-- ============================================================
     targetform.blade.php
     Form Tambah / Edit Target Belajar Mingguan (Mappy Path)
     Digunakan untuk DUA kondisi:
       1. Tambah baru  → route: target.create  | action: target.store
       2. Edit existing→ route: target.edit     | action: target.update
     Layout: sidebar kiri (identik dengan target.blade.php) + konten kanan
     Fitur:
       - Dropdown "Apa yang ingin kamu capai" (jenis target)
       - Input angka "Berapa Banyak"
       - Dropdown "Durasi Target" (minggu berjalan)
       - Tombol Simpan aktif hanya jika form terisi
       - Validasi inline (merah + pesan)
       - Smooth transitions + responsive
     ============================================================ --}}

@extends('layouts.app')

@section('title', isset($target) ? 'Edit Target Belajar' : 'Tambah Target Belajar')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

  :root {
    --primary: #6c3fc5;
    --primary-dark: #5a2fa8;
    --primary-light: #ede9fb;
    --sidebar-bg: #ece9f8;
    --sidebar-active: #5a2fa8;
    --danger: #e53935;
    --success: #22c55e;
    --text-main: #1a1a2e;
    --text-muted: #9399a6;
    --card-bg: #ffffff;
    --page-bg: #f7f6fd;
    --border: #e5e7eb;
    --border-focus: #6c3fc5;
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

  /* ═══════════════ SIDEBAR (identik target.blade.php) ═══════════════ */
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

  .sidebar-logo { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }

  .sidebar-logo-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #7c4dff, #5a2fa8);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
  }

  .sidebar-logo span { font-size: 20px; font-weight: 800; }

  .sidebar-nav { flex: 1; display: flex; flex-direction: column; gap: 4px; }

  .nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px; border-radius: 12px;
    color: #555; font-weight: 600; font-size: 15px;
    text-decoration: none;
    transition: background .2s, color .2s, transform .15s;
  }

  .nav-item:hover { background: rgba(108,63,197,.12); color: var(--primary); transform: translateX(3px); }
  .nav-item.active { background: var(--sidebar-active); color: #fff; }
  .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

  .sidebar-bottom { display: flex; flex-direction: column; gap: 4px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,.08); }
  .nav-item.danger { color: var(--danger); }
  .nav-item.danger:hover { background: #fce4e4; }

  .hamburger {
    display: none; position: fixed; top: 18px; left: 16px; z-index: 200;
    background: var(--primary); color: #fff; border: none; border-radius: 10px;
    padding: 8px 10px; cursor: pointer; font-size: 18px;
  }

  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.4); z-index: 90;
  }

  /* ═══════════════ MAIN CONTENT ═══════════════ */
  .main {
    margin-left: var(--sidebar-w);
    flex: 1;
    padding: 48px 56px;
  }

  .page-header { margin-bottom: 32px; }

  .page-header h1 {
    font-size: 32px; font-weight: 800;
    color: var(--text-main); line-height: 1.2;
  }

  .page-header p { color: var(--text-muted); font-size: 15px; margin-top: 6px; }

  /* ─── Back button ─── */
  .btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    background: #f0eef8; color: var(--primary);
    border: none; border-radius: 12px;
    padding: 11px 20px;
    font-size: 15px; font-weight: 700;
    cursor: pointer; text-decoration: none;
    transition: background .2s, transform .15s;
    margin-bottom: 28px;
  }

  .btn-back:hover { background: var(--primary-light); transform: translateX(-2px); }
  .btn-back svg  { width: 18px; height: 18px; }

  /* ═══════════════ FORM CARD ═══════════════ */
  .form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    padding: 36px 40px;
    max-width: 820px;
    animation: fadeInUp .4s ease;
  }

  /* ─── Field group ─── */
  .field-group { margin-bottom: 28px; }

  .field-label {
    display: block;
    font-size: 15px; font-weight: 700;
    color: var(--text-main);
    margin-bottom: 10px;
  }

  .field-hint {
    font-size: 12.5px;
    color: var(--text-muted);
    margin-top: 6px;
    display: block;
  }

  /* ─── Shared input/select styles ─── */
  .field-input,
  .field-select {
    width: 100%;
    padding: 14px 16px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 15px;
    font-family: inherit;
    color: var(--text-main);
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    appearance: none;
    -webkit-appearance: none;
  }

  .field-input:focus,
  .field-select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(108,63,197,.12);
  }

  .field-input.error,
  .field-select.error {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(229,57,53,.1);
  }

  .error-msg {
    font-size: 12px; font-weight: 600;
    color: var(--danger);
    margin-top: 5px;
    display: none;
  }

  /* ─── Select wrapper (custom chevron) ─── */
  .select-wrapper { position: relative; }

  .select-wrapper::after {
    content: '';
    position: absolute;
    right: 16px; top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid #888;
  }

  /* ─── Number input: hide spinners ─── */
  .field-input[type="number"]::-webkit-inner-spin-button,
  .field-input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }
  .field-input[type="number"] { -moz-appearance: textfield; }

  /* ─── Number stepper ─── */
  .number-wrapper {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
  }

  .number-wrapper:focus-within {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(108,63,197,.12);
  }

  .number-wrapper.error { border-color: var(--danger); }

  .stepper-btn {
    width: 44px; height: 50px;
    border: none; background: #f8f8fb;
    cursor: pointer; font-size: 20px; line-height: 1;
    color: #555;
    transition: background .15s, color .15s;
    flex-shrink: 0;
  }

  .stepper-btn:hover { background: var(--primary-light); color: var(--primary); }

  .number-wrapper .field-input {
    border: none; border-radius: 0;
    text-align: center;
    font-size: 18px; font-weight: 700;
    flex: 1; padding: 12px 8px;
  }

  .number-wrapper .field-input:focus { box-shadow: none; }

  /* ─── Save button ─── */
  .btn-save {
    width: 100%;
    padding: 16px;
    border-radius: 12px;
    border: none;
    font-size: 16px; font-weight: 700;
    cursor: pointer;
    transition: all .25s;
    margin-top: 8px;
  }

  .btn-save:disabled {
    background: #e5e7eb;
    color: #aaa;
    cursor: not-allowed;
    box-shadow: none;
  }

  .btn-save:not(:disabled) {
    background: linear-gradient(135deg, #7c4dff, #5a2fa8);
    color: #fff;
    box-shadow: 0 4px 18px rgba(108,63,197,.35);
  }

  .btn-save:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(108,63,197,.45);
  }

  /* ═══════════════ ANIMATIONS ═══════════════ */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ─── Toast ─── */
  .toast {
    position: fixed; bottom: 24px; right: 24px;
    padding: 14px 22px; border-radius: 12px;
    font-size: 14px; font-weight: 600;
    color: #fff; z-index: 999;
    transform: translateY(80px); opacity: 0;
    transition: all .35s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
  }

  .toast.show { transform: translateY(0); opacity: 1; }
  .toast.success { background: var(--primary); }
  .toast.error   { background: var(--danger); }

  /* ═══════════════ RESPONSIVE ═══════════════ */
  @media (max-width: 900px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .sidebar-overlay.open { display: block; }
    .hamburger { display: block; }
    .main { margin-left: 0; padding: 80px 20px 40px; }
  }

  @media (max-width: 560px) {
    .page-header h1 { font-size: 24px; }
    .form-card { padding: 22px 18px; }
    .main { padding: 72px 14px 32px; }
  }
</style>
@endpush

@section('content')

<button class="hamburger" id="hamburgerBtn" aria-label="Menu">&#9776;</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ════════ SIDEBAR ════════ -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon">📖</div>
    <span>Mappy Path</span>
  </div>

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

    <a href="{{ route('target.index') }}" class="nav-item active">
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

<!-- ════════ MAIN ════════ -->
<main class="main">

  <!-- Header -->
  <div class="page-header">
    <h1>Target Belajar Mingguan</h1>
    <p>Tentukan apa yang ingin kamu capai minggu ini</p>
  </div>

  <!-- Back button -->
  <a href="{{ route('target.index') }}" class="btn-back">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali
  </a>

  <!-- ═══ FORM CARD ═══ -->
  <div class="form-card">

    {{--
      Untuk tambah baru  → action="route('target.store')"    method POST
      Untuk edit         → action="route('target.update', $target->id)" method POST + @method('PUT')
    --}}
    <form
      id="targetForm"
      method="POST"
      action="{{ isset($target) ? route('target.update', $target->id) : route('target.store') }}"
    >
      @csrf
      @if(isset($target)) @method('PUT') @endif

      {{-- ─── 1. Jenis Target ─── --}}
      <div class="field-group">
        <label class="field-label" for="jenis">Apa yang ingin kamu capai?</label>

        <div class="select-wrapper">
          <select
            class="field-select @error('jenis') error @enderror"
            id="jenis"
            name="jenis"
            required
          >
            <option value="" disabled {{ old('jenis', $target->jenis ?? '') === '' ? 'selected' : '' }}>
              Pilih jenis target…
            </option>
            @foreach([
              'Menyelesaikan Materi',
              'Mengerjakan Latihan',
              'Membaca Buku',
              'Menonton Video',
              'Mengikuti Kuis',
            ] as $opt)
              <option value="{{ $opt }}"
                {{ old('jenis', $target->jenis ?? '') === $opt ? 'selected' : '' }}>
                {{ $opt }}
              </option>
            @endforeach
          </select>
        </div>

        <span class="field-hint">Pilih jenis target yang ingin kamu capai</span>
        @error('jenis')
          <span class="error-msg" style="display:block">{{ $message }}</span>
        @enderror
        <span class="error-msg" id="jenisErr">Wajib pilih jenis target</span>
      </div>

      {{-- ─── 2. Jumlah ─── --}}
      <div class="field-group">
        <label class="field-label" for="jumlah">Berapa Banyak?</label>

        <div class="number-wrapper" id="numberWrapper">
          <button type="button" class="stepper-btn" id="decBtn">−</button>
          <input
            class="field-input"
            type="number"
            id="jumlah"
            name="jumlah"
            min="1"
            max="999"
            placeholder="Contoh : 3"
            value="{{ old('jumlah', $target->target ?? '') }}"
            autocomplete="off"
          />
          <button type="button" class="stepper-btn" id="incBtn">+</button>
        </div>

        <span class="field-hint">Jumlah {{ isset($target) ? Str::lower($target->jenis) : 'materi' }} yang ingin diselesaikan</span>
        @error('jumlah')
          <span class="error-msg" style="display:block">{{ $message }}</span>
        @enderror
        <span class="error-msg" id="jumlahErr">Wajib masukkan jumlah (minimal 1)</span>
      </div>

      {{-- ─── 3. Durasi ─── --}}
      <div class="field-group">
        <label class="field-label" for="durasi">Durasi Target</label>

        @php
          // Hitung minggu berjalan & beberapa minggu ke depan
          $now   = \Carbon\Carbon::now();
          $weeks = [];
          for ($i = 0; $i < 4; $i++) {
            $start = $now->copy()->startOfWeek()->addWeeks($i);
            $end   = $start->copy()->endOfWeek();
            $label = $i === 0
              ? 'Minggu Ini (' . $start->translatedFormat('j M') . ' - ' . $end->translatedFormat('j M Y') . ')'
              : 'Minggu ke-' . ($i+1) . ' (' . $start->translatedFormat('j M') . ' - ' . $end->translatedFormat('j M Y') . ')';
            $weeks[] = [
              'value' => $start->toDateString() . '|' . $end->toDateString(),
              'label' => $label,
            ];
          }

          $selectedDurasi = old('durasi');
          if (!$selectedDurasi && isset($target)) {
            $selectedDurasi = $target->mulai . '|' . $target->selesai_tanggal;
          }
          if (!$selectedDurasi) {
            $selectedDurasi = $weeks[0]['value']; // default: minggu ini
          }
        @endphp

        <div class="select-wrapper">
          <select class="field-select @error('durasi') error @enderror" id="durasi" name="durasi" required>
            @foreach($weeks as $week)
              <option value="{{ $week['value'] }}"
                {{ $selectedDurasi === $week['value'] ? 'selected' : '' }}>
                {{ $week['label'] }}
              </option>
            @endforeach
          </select>
        </div>

        <span class="field-hint">Target akan berlaku untuk minggu berjalan</span>
        @error('durasi')
          <span class="error-msg" style="display:block">{{ $message }}</span>
        @enderror
      </div>

      {{-- ─── Save ─── --}}
      <button class="btn-save" type="submit" id="saveBtn" disabled>
        {{ isset($target) ? 'Simpan Perubahan' : 'Simpan Target' }}
      </button>

    </form><!-- /form -->
  </div><!-- /form-card -->

</main>

<!-- Toast -->
<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
  // ─── Sidebar toggle (mobile) ───
  const sidebar   = document.getElementById('sidebar');
  const overlay   = document.getElementById('sidebarOverlay');
  const hamburger = document.getElementById('hamburgerBtn');

  hamburger?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
  });
  overlay?.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
  });

  // ─── Form validation + enable/disable Save ───
  const jenisEl   = document.getElementById('jenis');
  const jumlahEl  = document.getElementById('jumlah');
  const durasEl   = document.getElementById('durasi');
  const saveBtn   = document.getElementById('saveBtn');
  const jenisErr  = document.getElementById('jenisErr');
  const jumlahErr = document.getElementById('jumlahErr');
  const numWrap   = document.getElementById('numberWrapper');

  function checkForm() {
    const jenisOk  = jenisEl.value  !== '';
    const jumlahOk = jumlahEl.value !== '' && parseInt(jumlahEl.value) >= 1;
    const durasOk  = durasEl.value  !== '';
    saveBtn.disabled = !(jenisOk && jumlahOk && durasOk);
  }

  // inline validation on blur
  jenisEl.addEventListener('blur', () => {
    if (!jenisEl.value) {
      jenisEl.classList.add('error');
      jenisErr.style.display = 'block';
    } else {
      jenisEl.classList.remove('error');
      jenisErr.style.display = 'none';
    }
    checkForm();
  });

  jenisEl.addEventListener('change', () => {
    jenisEl.classList.remove('error');
    jenisErr.style.display = 'none';
    checkForm();
  });

  jumlahEl.addEventListener('input', () => {
    const v = parseInt(jumlahEl.value);
    if (!jumlahEl.value || v < 1) {
      numWrap.classList.add('error');
      jumlahErr.style.display = 'block';
    } else {
      numWrap.classList.remove('error');
      jumlahErr.style.display = 'none';
    }
    checkForm();
  });

  durasEl.addEventListener('change', checkForm);

  // ─── Stepper buttons ───
  document.getElementById('incBtn').addEventListener('click', () => {
    const cur = parseInt(jumlahEl.value) || 0;
    if (cur < 999) {
      jumlahEl.value = cur + 1;
      jumlahEl.dispatchEvent(new Event('input'));
    }
  });

  document.getElementById('decBtn').addEventListener('click', () => {
    const cur = parseInt(jumlahEl.value) || 0;
    if (cur > 1) {
      jumlahEl.value = cur - 1;
      jumlahEl.dispatchEvent(new Event('input'));
    }
  });

  // run on load (for edit pre-filled values)
  checkForm();

  // ─── Server-side flash validation errors ───
  @if($errors->any())
    showToast('Periksa kembali form kamu.', 'error');
  @endif

  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    t.className = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3500);
  }
</script>
@endpush