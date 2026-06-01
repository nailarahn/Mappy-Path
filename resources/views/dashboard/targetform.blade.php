@extends('layouts.dashboard')

@section('title', isset($target) ? 'Edit Target' : 'Tambah Target')

@push('styles')
<style>
  .page-hdr { margin-bottom: 24px; }
  .page-hdr h1 { font-size: 28px; font-weight: 800; color: var(--gray-800); }
  .page-hdr p  { color: var(--gray-400); font-size: 14px; margin-top: 4px; }

  /* back btn */
  .btn-back {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--gray-100); color: var(--primary);
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all .2s; margin-bottom: 24px;
    font-family: var(--font);
  }
  .btn-back:hover { background: var(--gray-200); color: var(--primary); }
  .btn-back svg { width: 16px; height: 16px; }

  /* form card */
  .form-card {
    background: #fff; border-radius: 16px;
    border: 1.5px solid var(--gray-200);
    padding: 32px 36px; max-width: 860px;
    box-shadow: var(--shadow);
  }

  /* field */
  .field { margin-bottom: 24px; }

  .field-lbl {
    display: block; font-size: 14px; font-weight: 700;
    color: var(--gray-800); margin-bottom: 8px;
  }

  .field-hint { font-size: 12px; color: var(--gray-400); margin-top: 5px; display: block; }

  /* inputs */
  .f-input, .f-select, .f-textarea {
    width: 100%; padding: 12px 15px;
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    font-size: 14px; font-family: var(--font); color: var(--gray-800);
    background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  .f-input:focus, .f-select:focus, .f-textarea:focus {
    border-color: var(--primary); box-shadow: 0 0 0 3px rgba(55,36,102,.08);
  }
  .f-select { appearance: none; -webkit-appearance: none; cursor: pointer; }
  .f-textarea { resize: vertical; min-height: 88px; }

  .sel-wrap { position: relative; }
  .sel-wrap::after {
    content: ''; position: absolute; right: 15px; top: 50%;
    transform: translateY(-50%); pointer-events: none;
    width: 0; height: 0;
    border-left: 5px solid transparent; border-right: 5px solid transparent;
    border-top: 6px solid var(--gray-400);
  }

  /* number input */
  .f-input[type="number"] { -moz-appearance: textfield; }
  .f-input[type="number"]::-webkit-inner-spin-button,
  .f-input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }

  /* error */
  .err-msg { font-size: 12px; font-weight: 600; color: #dc2626; margin-top: 5px; display: none; }

  /* save btn */
  .btn-save {
    width: 100%; padding: 14px; border-radius: 10px; border: none;
    font-size: 15px; font-weight: 700; cursor: pointer;
    font-family: var(--font); transition: all .2s; margin-top: 6px;
  }
  .btn-save:disabled { background: var(--gray-200); color: var(--gray-400); cursor: not-allowed; }
  .btn-save:not(:disabled) {
    background: var(--primary);
    color: #fff; box-shadow: 0 4px 16px rgba(55,36,102,.25);
  }
  .btn-save:not(:disabled):hover { background: var(--primary-light); transform: translateY(-1px); }

  /* toast */
  .toast {
    position: fixed; bottom: 22px; right: 22px;
    padding: 11px 16px; border-radius: 11px;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
    z-index: 999; opacity: 0; transform: translateY(12px);
    transition: all .3s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 8px 24px rgba(0,0,0,.12); max-width: 280px;
  }
  .toast.show    { opacity: 1; transform: translateY(0); }
  .toast.success { background: #059669; color: #fff; }
  .toast.error   { background: #ef4444; color: #fff; }

  @media (max-width: 560px) {
    .page-hdr h1 { font-size: 20px; }
    .form-card { padding: 20px 16px; }
  }
</style>
@endpush

@section('content')

<div class="page-hdr">
  <h1>Target Belajar Mingguan</h1>
  <p>Tentukan apa yang ingin kamu capai minggu ini</p>
</div>

<a href="{{ route('target') }}" class="btn-back">
  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    <polyline points="15 18 9 12 15 6"/>
  </svg>
  Kembali
</a>

<div class="form-card">
  <form id="targetForm" method="POST"
        action="{{ isset($target) ? route('target.update', $target->id) : route('target.store') }}">
    @csrf
    @if(isset($target)) @method('PUT') @endif

    {{-- 1. Apa yang ingin dicapai --}}
    <div class="field">
      <label class="field-lbl" for="name">Apa yang ingin kamu capai?</label>
      <div class="sel-wrap">
        <select class="f-select" id="name" name="name" required>
          <option value="" disabled {{ old('name', $target->name ?? '') === '' ? 'selected' : '' }}>
            Pilih jenis target…
          </option>
          @foreach(['Menyelesaikan Materi','Mengerjakan Latihan','Membaca Buku','Menonton Video','Mengikuti Kuis'] as $opt)
            <option value="{{ $opt }}" {{ old('name', $target->name ?? '') === $opt ? 'selected' : '' }}>
              {{ $opt }}
            </option>
          @endforeach
        </select>
      </div>
      <span class="field-hint">Pilih jenis target yang ingin kamu capai</span>
      @error('name')
        <span class="err-msg" style="display:block">{{ $message }}</span>
      @enderror
      <span class="err-msg" id="nameErr">Wajib pilih jenis target</span>
    </div>

    {{-- 2. Berapa Banyak --}}
    <div class="field">
      <label class="field-lbl" for="target_value">Berapa Banyak?</label>
      <input type="number" class="f-input" id="target_value" name="target_value"
             min="1" max="999" placeholder="Contoh : 3"
             value="{{ old('target_value', $target->target_value ?? '') }}"
             autocomplete="off" required>
      <span class="field-hint">Jumlah materi yang ingin diselesaikan</span>
      @error('target_value')
        <span class="err-msg" style="display:block">{{ $message }}</span>
      @enderror
      <span class="err-msg" id="valErr">Wajib masukkan jumlah (minimal 1)</span>
    </div>

    {{-- 3. Durasi Target (dropdown minggu) --}}
    <div class="field">
      <label class="field-lbl" for="deadline">Durasi Target</label>
      <div class="sel-wrap">
        <select class="f-select" id="deadline" name="deadline">
          @php
            use Carbon\Carbon;
            $weeks = [];
            $now   = Carbon::now();
            // Hasilkan 4 minggu: minggu ini + 3 minggu ke depan
            for ($i = 0; $i < 4; $i++) {
              $start = $now->copy()->addWeeks($i)->startOfWeek(Carbon::MONDAY);
              $end   = $start->copy()->endOfWeek(Carbon::SUNDAY);
              $label = ($i === 0 ? 'Minggu Ini' : 'Minggu ke-' . ($i+1))
                       . ' (' . $start->translatedFormat('j M') . ' - ' . $end->translatedFormat('j M Y') . ')';
              $weeks[] = ['value' => $end->format('Y-m-d'), 'label' => $label];
            }
            $currentDeadline = old('deadline', isset($target) ? $target->deadline?->format('Y-m-d') : '');
          @endphp

          @foreach($weeks as $week)
            <option value="{{ $week['value'] }}" {{ $currentDeadline === $week['value'] ? 'selected' : '' }}>
              {{ $week['label'] }}
            </option>
          @endforeach
        </select>
      </div>
      <span class="field-hint">Target akan berlaku untuk minggu berjalan</span>
    </div>

    <button class="btn-save" type="submit" id="saveBtn" disabled>
      {{ isset($target) ? 'Update Target' : 'Simpan Target' }}
    </button>

  </form>
</div>

<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
  const nameEl  = document.getElementById('name');
  const valEl   = document.getElementById('target_value');
  const saveBtn = document.getElementById('saveBtn');
  const nameErr = document.getElementById('nameErr');
  const valErr  = document.getElementById('valErr');

  function check() {
    const ok = nameEl.value !== '' && valEl.value !== '' && parseInt(valEl.value) >= 1;
    saveBtn.disabled = !ok;
  }

  nameEl.addEventListener('change', () => { nameErr.style.display = 'none'; check(); });
  nameEl.addEventListener('blur',   () => { if (!nameEl.value) nameErr.style.display = 'block'; check(); });

  valEl.addEventListener('input', () => {
    const v = parseInt(valEl.value);
    if (!valEl.value || v < 1) { valEl.style.borderColor = '#dc2626'; valErr.style.display = 'block'; }
    else                       { valEl.style.borderColor = ''; valErr.style.display = 'none'; }
    check();
  });

  check();

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