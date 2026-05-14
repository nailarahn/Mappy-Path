@extends('layouts.app')

@section('content')

<!-- Navbar -->
<nav class="w-full px-10 py-6 flex items-center justify-between">

    <!-- Logo -->
    <div class="flex items-center gap-4">

        <div class="w-14 h-14 bg-primary-500 rounded-2xl flex items-center justify-center shadow-card">
            <span class="text-white text-2xl">📖</span>
        </div>

        <h1 class="text-3xl font-bold">
            Mappy Path
        </h1>

    </div>

    <!-- Buttons -->
    <div class="flex items-center gap-4">

        <button class="btn-secondary">
            Masuk
        </button>

        <button class="btn-primary">
            Daftar Gratis
        </button>

    </div>

</nav>

<!-- Hero -->
<section class="max-w-6xl mx-auto px-8 pt-24 text-center">

    <h1 class="heading-hero">
        Wujudkan Impianmu di
        <span class="text-primary-500">
            Dunia IT
        </span>
    </h1>

    <p class="text-body mt-10 max-w-5xl mx-auto">
        Platform roadmap pembelajaran yang dirancang khusus untuk siswa SMK Teknik Komputer dan Jaringan.
        Rencanakan, pantau, dan capai target belajarmu dengan lebih terstruktur.
    </p>

    <!-- CTA -->
    <div class="mt-14">

        <button class="btn-primary text-xl px-12 py-5">
            Daftar Gratis →
        </button>

    </div>

    <!-- Stats -->
    <div class="mt-16 flex items-center justify-center gap-16 flex-wrap text-xl text-neutral-700">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 border-2 border-neutral-300 rounded-full flex items-center justify-center">
                ✓
            </div>

            <span>Gratis selamanya</span>

        </div>

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 border-2 border-neutral-300 rounded-full flex items-center justify-center">
                ✓
            </div>

            <span>500+ materi</span>

        </div>

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 border-2 border-neutral-300 rounded-full flex items-center justify-center">
                ✓
            </div>

            <span>1000+ siswa</span>

        </div>

    </div>

</section>

<!-- Dashboard Preview -->
<section class="max-w-5xl mx-auto px-8 mt-28">

    <div class="bg-gradient-to-r from-primary-700 to-primary-400 p-5 rounded-xl4 shadow-glow">

        <div class="bg-white rounded-xl3 p-8">

            <!-- Profile -->
            <div class="flex items-center gap-5">

                <div class="w-16 h-16 rounded-2xl bg-primary-500 flex items-center justify-center text-white text-2xl">
                    👤
                </div>

                <div>

                    <h2 class="text-3xl font-bold">
                        Anatasha Berliane
                    </h2>

                    <p class="text-neutral-400 text-lg mt-1">
                        Jaringan Dasar - 75% selesai
                    </p>

                </div>

            </div>

            <!-- Progress -->
            <div class="mt-10 flex justify-between items-center">

                <p class="text-neutral-400 text-xl">
                    Progress Minggu Ini
                </p>

                <p class="font-bold text-2xl">
                    20/15 materi
                </p>

            </div>

            <!-- Progress Bar -->
            <div class="w-full h-4 bg-primary-50 rounded-full mt-4 overflow-hidden">

                <div class="w-[60%] h-full bg-gradient-to-r from-primary-700 to-primary-400 rounded-full"></div>

            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

                <div class="card-stat">

                    <h2 class="heading-card text-primary-700">
                        64
                    </h2>

                    <p class="text-2xl mt-3 text-neutral-700">
                        Materi
                    </p>

                </div>

                <div class="card-stat">

                    <h2 class="heading-card text-primary-500">
                        18h
                    </h2>

                    <p class="text-2xl mt-3 text-neutral-700">
                        Minggu ini
                    </p>

                </div>

                <div class="card-stat">

                    <h2 class="heading-card text-green-600">
                        12
                    </h2>

                    <p class="text-2xl mt-3 text-neutral-700">
                        Badge
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Footer -->
<footer class="bg-primary-900 mt-40 text-white">

    <div class="max-w-6xl mx-auto px-8 py-20 text-center">

        <!-- Logo -->
        <div class="flex justify-center items-center gap-4">

            <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-primary-500 text-3xl">
                📖
            </div>

            <h2 class="text-5xl font-bold">
                Mappy Path
            </h2>

        </div>

        <p class="mt-8 text-xl text-primary-100">
            Platform roadmap pembelajaran untuk siswa SMK Teknik Komputer dan Jaringan
        </p>

        <!-- Dots -->
        <div class="flex justify-center gap-5 mt-10">

            <div class="w-7 h-7 rounded-full bg-primary-700"></div>
            <div class="w-7 h-7 rounded-full bg-primary-700"></div>
            <div class="w-7 h-7 rounded-full bg-primary-700"></div>
            <div class="w-7 h-7 rounded-full bg-primary-700"></div>

        </div>

        <!-- Bottom -->
        <div class="mt-16 bg-primary-800 rounded-2xl px-8 py-6 flex flex-col md:flex-row items-center justify-between text-lg">

            <p>
                Copyright © 2026 Mappy Path. All Rights Reserved.
            </p>

            <div class="flex gap-8 mt-4 md:mt-0">

                <a href="#" class="hover:text-primary-200">
                    Privacy Policy
                </a>

                <a href="#" class="hover:text-primary-200">
                    Terms of use
                </a>

            </div>

        </div>

    </div>

</footer>

@endsection