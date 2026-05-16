@extends('layouts.app')

@section('title', 'Mappy Path - Wujudkan Impianmu di Dunia IT')

@push('head')
<style>
/* ===== LANDING PAGE ===== */
:root {
    --primary: #372466;
    --primary-light: #4e35a0;
    --accent: #7c5cbf;
    --accent-light: #a78bd4;
    --white: #ffffff;
    --gray-50: #fafafa;
    --gray-100: #f4f1ff;
    --gray-200: #e4e0f5;
    --gray-400: #9589b8;
    --gray-500: #6d5f9a;
    --gray-700: #332a5c;
    --gray-800: #1e1640;
    --font: 'Poppins', sans-serif;
}

body { background: var(--white); }

/* NAVBAR */
.navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--gray-200);
    padding: 0 5%;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.nav-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}
.nav-logo {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 0.9rem;
}
.logo-icon img {
    width: 40px;
    height: 40px;
    object-fit: contain;
}
.nav-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--primary);
}
.nav-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.btn-nav-login {
    padding: 0.55rem 1.4rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid var(--gray-200);
    background: transparent;
    color: var(--primary);
    text-decoration: none;
    transition: all 0.2s;
}
.btn-nav-login:hover { border-color: var(--primary); background: var(--gray-100); }
.btn-nav-daftar {
    padding: 0.55rem 1.4rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid var(--primary);
    background: var(--primary);
    color: white;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-nav-daftar:hover { background: var(--primary-light); border-color: var(--primary-light); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(55,36,102,0.3); }

/* HERO */
.hero {
    text-align: center;
    padding: 6rem 5% 5rem;
    background: linear-gradient(180deg, var(--white) 0%, var(--gray-100) 100%);
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(55,36,102,0.06) 0%, transparent 70%);
    pointer-events: none;
}
.hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(124,92,191,0.06) 0%, transparent 70%);
    pointer-events: none;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--gray-100);
    border: 1.5px solid var(--gray-200);
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    margin-bottom: 1.5rem;
    animation: fadeSlideDown 0.6s ease forwards;
}
.hero-title {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800;
    color: var(--gray-800);
    line-height: 1.2;
    margin-bottom: 1.25rem;
    animation: fadeSlideDown 0.7s ease forwards;
}
.hero-title span { color: var(--primary); }
.hero-desc {
    font-size: clamp(0.95rem, 2vw, 1.1rem);
    color: var(--gray-500);
    max-width: 600px;
    margin: 0 auto 2.5rem;
    line-height: 1.7;
    animation: fadeSlideDown 0.8s ease forwards;
}
.hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: var(--primary);
    color: white;
    padding: 0.9rem 2.2rem;
    border-radius: 12px;
    font-family: var(--font);
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    animation: fadeSlideDown 0.9s ease forwards;
    border: 2px solid var(--primary);
}
.hero-cta:hover { background: var(--primary-light); border-color: var(--primary-light); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(55,36,102,0.35); }
.hero-cta-arrow {
    width: 20px;
    height: 20px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2.5rem;
    margin-top: 3rem;
    flex-wrap: wrap;
    animation: fadeSlideDown 1s ease forwards;
}
.hero-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    font-size: 0.875rem;
    font-weight: 500;
}
.stat-check {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid var(--gray-300);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

/* DEMO CARD */
.demo-section {
    display: flex;
    justify-content: center;
    padding: 2rem 5% 5rem;
    background: linear-gradient(180deg, var(--gray-100) 0%, var(--white) 100%);
}
.demo-card {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 20px;
    padding: 2rem;
    color: white;
    width: 100%;
    max-width: 650px;
    box-shadow: 0 20px 60px rgba(55,36,102,0.3);
    animation: floatCard 4s ease-in-out infinite;
}
@keyframes floatCard {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.demo-user {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.demo-avatar {
    width: 52px;
    height: 52px;
    background: rgba(255,255,255,0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 700;
}
.demo-user-name { font-size: 1.05rem; font-weight: 700; }
.demo-user-stage { font-size: 0.85rem; opacity: 0.8; }

.demo-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    opacity: 0.85;
    margin-bottom: 0.5rem;
}
.demo-bar {
    height: 10px;
    background: rgba(255,255,255,0.2);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.demo-bar-fill {
    height: 100%;
    width: 75%;
    background: rgba(255,255,255,0.85);
    border-radius: 5px;
}
.demo-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
.demo-stat-box {
    background: rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
}
.demo-stat-value {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
}
.demo-stat-value.orange { color: #fbbf24; }
.demo-stat-value.green { color: #86efac; }
.demo-stat-label { font-size: 0.78rem; opacity: 0.75; margin-top: 0.3rem; }

/* FEATURES */
.features-section {
    padding: 5rem 5%;
    background: var(--white);
}
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}
.section-tag {
    display: inline-block;
    background: var(--gray-100);
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    margin-bottom: 1rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.section-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: var(--gray-800);
    margin-bottom: 0.75rem;
}
.section-desc {
    color: var(--gray-500);
    font-size: 1rem;
    max-width: 550px;
    margin: 0 auto;
    line-height: 1.7;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}
.feature-card {
    background: var(--white);
    border: 1.5px solid var(--gray-200);
    border-radius: 16px;
    padding: 1.75rem;
    transition: all 0.3s;
}
.feature-card:hover {
    border-color: var(--accent-light);
    box-shadow: 0 10px 40px rgba(55,36,102,0.1);
    transform: translateY(-4px);
}
.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.1rem;
    transition: background 0.3s;
}
.feature-card:hover .feature-icon { background: linear-gradient(135deg, var(--primary), var(--accent)); }
.feature-title { font-size: 1rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0.5rem; }
.feature-desc { font-size: 0.875rem; color: var(--gray-500); line-height: 1.6; }

/* FOOTER */
.footer {
    background: var(--primary);
    color: white;
    padding: 3rem 5% 1.5rem;
}
.footer-top {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(255,255,255,0.15);
    text-align: center;
}
.footer-brand { display: flex; align-items: center; gap: 0.75rem; }
.footer-logo {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    color: white;
    font-size: 0.95rem;
    object-fit: contain;
}
.footer-brand-name { font-size: 1.15rem; font-weight: 700; }
.footer-tagline { font-size: 0.875rem; opacity: 0.7; margin-top: 0.5rem; }
.footer-socials { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
.social-btn {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 1rem;
}
.social-btn:hover { background: rgba(255,255,255,0.25); }

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    font-size: 0.8rem;
    opacity: 0.6;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.footer-links { display: flex; gap: 1.5rem; }
.footer-links a { color: white; text-decoration: none; }
.footer-links a:hover { text-decoration: underline; }

/* ANIMATIONS */
@keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .features-grid { grid-template-columns: 1fr 1fr; }
    .hero-stats { gap: 1.5rem; }
    .demo-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 520px) {
    .features-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; text-align: center; }
    .nav-actions .btn-nav-login { display: none; }
}
</style>
@endpush

@section('content')

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('landing') }}" class="nav-brand">
        <div class="logo-icon">
            <img src="img/Icon.png" alt="Logo Mappy Path">
        </div>
        <span class="nav-name">Mappy Path</span>
    </a>
    <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-daftar">Daftar Gratis</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge">
        🎓 Platform Belajar IT untuk Siswa SMK TKJ
    </div>
    <h1 class="hero-title">
        Wujudkan Impianmu di <span>Dunia IT</span>
    </h1>
    <p class="hero-desc">
        Platform roadmap pembelajaran yang dirancang khusus untuk siswa SMK Teknik Komputer dan
        Jaringan. Rencanakan, pantau, dan capai target belajarmu dengan lebih terstruktur.
    </p>
    <a href="{{ route('login') }}" class="hero-cta">
        Daftar Gratis
        <div class="hero-cta-arrow">→</div>
    </a>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            Gratis selamanya
        </div>
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            500+ materi
        </div>
        <div class="hero-stat">
            <div class="stat-check">✓</div>
            1000+ siswa
        </div>
    </div>
</section>

<!-- DEMO CARD -->
<section class="demo-section">
    <div class="demo-card">
        <div class="demo-user">
            <div class="demo-avatar">A</div>
            <div>
                <div class="demo-user-name">Anatasha Berliane</div>
                <div class="demo-user-stage">Jaringan Dasar - 75% selesai</div>
            </div>
        </div>
        <div class="demo-progress-label">
            <span>Progress Minggu Ini</span>
            <span style="font-weight:700;">20/15 materi</span>
        </div>
        <div class="demo-bar">
            <div class="demo-bar-fill"></div>
        </div>
        <div class="demo-stats">
            <div class="demo-stat-box">
                <div class="demo-stat-value">64</div>
                <div class="demo-stat-label">Materi</div>
            </div>
            <div class="demo-stat-box">
                <div class="demo-stat-value orange">18h</div>
                <div class="demo-stat-label">Minggu ini</div>
            </div>
            <div class="demo-stat-box">
                <div class="demo-stat-value green">12</div>
                <div class="demo-stat-label">Badge</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section">
    <div class="section-header">
        <div class="section-tag">Fitur Unggulan</div>
        <h2 class="section-title">Semua yang kamu butuhkan ada di sini</h2>
        <p class="section-desc">Belajar jadi lebih mudah, terarah, dan menyenangkan dengan fitur-fitur yang kami siapkan untukmu.</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🗺️</div>
            <div class="feature-title">Roadmap Terstruktur</div>
            <div class="feature-desc">Peta belajar yang sudah disusun oleh guru dan praktisi IT berpengalaman sesuai kurikulum TKJ.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <div class="feature-title">Pantau Progress</div>
            <div class="feature-desc">Lihat perkembangan belajarmu setiap hari, minggu, dan bulan dengan grafik yang mudah dipahami.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎯</div>
            <div class="feature-title">Target Belajar</div>
            <div class="feature-desc">Atur target mingguan dan bulanan, dapatkan pengingat supaya kamu tidak ketinggalan materi.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <div class="feature-title">Badge & Prestasi</div>
            <div class="feature-desc">Kumpulkan badge setiap kali menyelesaikan materi dan buktikan kemampuanmu kepada semua orang.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📚</div>
            <div class="feature-title">500+ Materi</div>
            <div class="feature-desc">Video, artikel, dan latihan soal yang selalu diperbarui sesuai perkembangan teknologi terkini.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💡</div>
            <div class="feature-title">Rekomendasi Cerdas</div>
            <div class="feature-desc">Sistem akan merekomendasikan materi yang paling relevan berdasarkan progres dan minatmu.</div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="img/Icon1.png" alt="Logo Mappy Path">
            </div>
            <span class="footer-brand-name">Mappy Path</span>
        </div>
        <p class="footer-tagline">Platform roadmap pembelajaran untuk siswa SMK Teknik Komputer dan Jaringan</p>
        <div class="footer-socials">
            <div class="social-btn">IG</div>
            <div class="social-btn">YT</div>
            <div class="social-btn">X</div>
            <div class="social-btn">Web</div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>Copyright © 2026 Mappy Path. All Rights Reserved.</span>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of use</a>
        </div>
    </div>
</footer>

@endsection
