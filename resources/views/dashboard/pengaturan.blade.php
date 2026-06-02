@extends('layouts.app', ['title' => 'Pengaturan', 'active' => 'pengaturan'])

@section('content')
<h1 class="text-3xl md:text-4xl font-bold text-gray-900">Pengaturan</h1>
<p class="text-gray-400 mt-1">Kelola preferensi dan akun Anda</p>

@if ($errors->any())
    <div class="mt-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-600">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('pengaturan.update') }}" class="mt-8 max-w-4xl space-y-6" x-data="{
    notif_email: {{ $user->notif_email ? 'true' : 'false' }},
    notif_push: {{ $user->notif_push ? 'true' : 'false' }},
    notif_weekly: {{ $user->notif_weekly ? 'true' : 'false' }}
}">
    @csrf @method('PUT')

    <!-- Profil -->
    <div class="rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-6 border-b border-gray-100 flex items-center gap-3">
            <span class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center text-primary-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><rect x="7" y="10" width="3" height="7"/><rect x="13" y="6" width="3" height="11"/></svg>
            </span>
            <div><p class="font-bold text-gray-900">Profil</p><p class="text-sm text-gray-400">Informasi akun Anda</p></div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="flex justify-center md:justify-start">
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-primary-300 to-primary-600 flex items-center justify-center text-white text-4xl font-bold">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300">
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div class="rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-6 border-b border-gray-100 flex items-center gap-3">
            <span class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center text-primary-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
            </span>
            <div><p class="font-bold text-gray-900">Notifikasi</p><p class="text-sm text-gray-400">Pengaturan pemberitahuan</p></div>
        </div>
        <div class="p-6 divide-y divide-gray-100">
            @php
                $toggles = [
                    ['model'=>'notif_email','name'=>'notif_email','title'=>'Email Notifikasi','desc'=>'Terima notifikasi via email'],
                    ['model'=>'notif_push','name'=>'notif_push','title'=>'Push Notification','desc'=>'Terima notifikasi push'],
                    ['model'=>'notif_weekly','name'=>'notif_weekly','title'=>'Laporan Mingguan','desc'=>'Terima ringkasan progress mingguan'],
                ];
            @endphp
            @foreach ($toggles as $tg)
            <div class="flex items-center justify-between py-4">
                <div><p class="font-semibold text-gray-800">{{ $tg['title'] }}</p><p class="text-sm text-gray-400">{{ $tg['desc'] }}</p></div>
                <button type="button" @click="{{ $tg['model'] }} = !{{ $tg['model'] }}"
                        class="w-12 h-6 rounded-full transition relative" :class="{{ $tg['model'] }} ? 'bg-primary-700' : 'bg-gray-300'">
                    <span class="absolute top-0.5 w-5 h-5 rounded-full bg-white shadow transition-all" :class="{{ $tg['model'] }} ? 'left-6' : 'left-0.5'"></span>
                </button>
                <input type="hidden" name="{{ $tg['name'] }}" :value="{{ $tg['model'] }} ? 1 : 0">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Keamanan -->
    <div class="rounded-2xl border border-gray-100 shadow-sm" x-data="{ showPwd:false }">
        <div class="p-6 border-b border-gray-100 flex items-center gap-3">
            <span class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center text-primary-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </span>
            <div><p class="font-bold text-gray-900">Keamanan</p><p class="text-sm text-gray-400">Pengaturan keamanan akun</p></div>
        </div>
        <div class="p-6 space-y-3">
            <button type="button" @click="showPwd = !showPwd" class="w-full text-left rounded-xl bg-gray-100 px-4 py-3.5 font-semibold text-gray-700 hover:bg-gray-200 transition">Ubah Password</button>

            <div x-show="showPwd" x-cloak class="rounded-xl border border-gray-100 p-4 space-y-3">
                <p class="text-sm text-gray-400">Isi form di bawah lalu klik "Simpan Password" (form terpisah).</p>
            </div>

            <button type="button" class="w-full text-left rounded-xl bg-gray-100 px-4 py-3.5 font-semibold text-gray-700 hover:bg-gray-200 transition">Aktifkan Two-Factor Authentication</button>
        </div>
    </div>

    <!-- Tombol simpan -->
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary-700 to-primary-500 text-white font-semibold hover:opacity-95 transition shadow-lg shadow-primary-700/30">Simpan Perubahan</button>
        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200 transition">Batalkan</a>
    </div>
</form>

<!-- Form ubah password (terpisah) -->
<form method="POST" action="{{ route('pengaturan.password') }}" class="mt-6 max-w-4xl rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
    @csrf @method('PUT')
    <p class="font-bold text-gray-900">Ubah Password</p>
    <div>
        <label class="block font-semibold text-gray-800 mb-2">Password Saat Ini</label>
        <input type="password" name="current_password" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block font-semibold text-gray-800 mb-2">Password Baru</label>
            <input type="password" name="password" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300">
        </div>
        <div>
            <label class="block font-semibold text-gray-800 mb-2">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-primary-300">
        </div>
    </div>
    <button type="submit" class="px-6 py-3 rounded-xl bg-primary-700 text-white font-semibold hover:bg-primary-800 transition">Simpan Password</button>
</form>
@endsection
