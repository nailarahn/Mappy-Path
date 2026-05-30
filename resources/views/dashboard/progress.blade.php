@extends('layouts.dashboard')

@section('title', 'Progress')

@push('styles')
<style>

/* ───────────────── PAGE ───────────────── */
.progress-wrapper{ padding:.25rem; }

.progress-title{
    font-size:1.6rem; font-weight:800;
    color:var(--gray-800); line-height:1.2;
}

.progress-subtitle{
    font-size:.92rem; color:var(--gray-400);
    margin-top:.35rem; margin-bottom:2rem;
}

/* ───────────────── STATS ───────────────── */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:1rem; margin-bottom:1.75rem;
}

.stats-card{
    background:var(--white);
    border:1.5px solid var(--gray-200);
    border-radius:20px; padding:1.35rem;
    transition:.25s;
}

.stats-card:hover{
    transform:translateY(-4px);
    box-shadow:0 14px 34px rgba(55,36,102,.08);
}

.stats-top{
    display:flex; align-items:center;
    justify-content:space-between; margin-bottom:.9rem;
}

.stats-icon{
    font-size:1.55rem;
    width:52px; height:52px;
    border-radius:16px;
    display:flex; align-items:center; justify-content:center;
    background:#f3edff;
}

.stats-badge{
    font-size:.72rem; font-weight:700;
    padding:.28rem .7rem; border-radius:20px;
}

.badge-green  { background:#e7fff1; color:#18b56a; }
.badge-blue   { background:#e8f0ff; color:#3b6cf4; }
.badge-purple { background:#efe9ff; color:#6C4CF1; }

.stats-label{ font-size:.82rem; color:var(--gray-400); font-weight:600; }

.stats-number{
    font-size:2rem; font-weight:800;
    color:var(--gray-800); line-height:1; margin-bottom:.55rem;
}

.stats-small{ font-size:.78rem; color:var(--gray-400); font-weight:500; }

/* ───────────────── CHART ───────────────── */
.chart-box{
    background:var(--white);
    border:1.5px solid var(--gray-200);
    border-radius:24px; padding:1.6rem; margin-bottom:1.75rem;
}

.chart-title{ font-size:1.15rem; font-weight:800; color:var(--gray-800); margin-bottom:.3rem; }
.chart-sub  { font-size:.82rem; color:var(--gray-400); margin-bottom:1.5rem; }

.chart-wrapper{ width:100%; overflow:hidden; border-radius:18px; }

/* ───────────────── ACHIEVEMENT ───────────────── */
.achievement-box{
    background:var(--white);
    border:1.5px solid var(--gray-200);
    border-radius:24px; padding:1.6rem;
}

.achievement-title{ font-size:1.15rem; font-weight:800; color:var(--gray-800); margin-bottom:.3rem; }
.achievement-sub  { font-size:.82rem; color:var(--gray-400); }

.achievement-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:1rem; margin-top:1.4rem;
}

/* UNLOCKED card */
.achievement-card{
    position:relative; overflow:hidden;
    border-radius:24px; padding:1.5rem 1.2rem 1.2rem;
    text-align:center;
    transition:all .35s cubic-bezier(.34,1.56,.64,1);
    background:linear-gradient(160deg,#fdfcff 0%,#f5f0ff 100%);
    border:1.5px solid rgba(108,76,241,.18);
    cursor:pointer;
}

.achievement-card:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow:0 22px 55px rgba(108,76,241,.18);
    border-color:#b09fff;
}

/* shine sweep */
.card-shine{
    position:absolute; inset:0;
    background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.6) 50%,transparent 60%);
    transform:translateX(-100%);
    transition:transform .55s ease;
    z-index:1; pointer-events:none;
}
.achievement-card:hover .card-shine{ transform:translateX(100%); }

.card-glow{ position:absolute; inset:0; pointer-events:none; z-index:0; }

/* badge */
.achievement-badge-wrap{
    position:relative; width:72px; height:72px;
    margin:0 auto 1rem;
    display:flex; align-items:center; justify-content:center;
    z-index:2; border-radius:20px;
}

.badge-emoji{ font-size:2rem; line-height:1; position:relative; z-index:2; }

.badge-ring{
    position:absolute; inset:-4px; border-radius:50%;
    border:2.5px solid transparent;
    animation:spin-ring 4s linear infinite;
}
@keyframes spin-ring{ to{ transform:rotate(360deg); } }

.purple-wrap{ background:#efe9ff; }
.purple-wrap .badge-ring{ border-top-color:#6C4CF1; border-right-color:#A586FF; }

.pink-wrap{ background:#ffe7ef; }
.pink-wrap .badge-ring{ border-top-color:#e54b7a; border-right-color:#ff8fab; }

.bronze-wrap{ background:#fff1e0; }
.bronze-wrap .badge-ring{ border-top-color:#cd7f32; border-right-color:#e8a96a; }

.silver-wrap{ background:#f1f1f1; }
.gold-wrap  { background:#fff4d8; }
.green-wrap { background:#e7fff1; }

.achievement-name{
    font-size:1rem; font-weight:800; color:var(--gray-800);
    margin-bottom:.3rem; position:relative; z-index:2;
}

.achievement-desc{
    font-size:.76rem; color:var(--gray-400);
    line-height:1.5; margin-bottom:.9rem; position:relative; z-index:2;
}

.achv-footer{
    display:flex; align-items:center; justify-content:space-between;
    position:relative; z-index:2;
}

.achv-xp{
    font-size:.72rem; font-weight:700;
    background:#efe9ff; color:#6C4CF1;
    padding:.25rem .65rem; border-radius:20px;
}

.achv-date{ font-size:.72rem; font-weight:600; color:var(--gray-400); }

/* LOCKED card */
.locked-card{
    border:1.5px dashed var(--gray-200) !important;
    background:#fafafa !important;
    cursor:default !important;
}
.locked-card:hover{
    transform:none !important;
    box-shadow:none !important;
    border-color:var(--gray-200) !important;
}

.lock-overlay{
    position:absolute; top:.8rem; right:.8rem;
    font-size:1rem; opacity:.45;
}

.locked-bar{
    height:5px; background:#eee; border-radius:10px;
    overflow:hidden; margin:.7rem 0 .3rem;
}
.locked-bar-fill{
    height:100%;
    background:linear-gradient(90deg,#b09fff,#6C4CF1);
    border-radius:10px;
}

.locked-progress-text{ font-size:.7rem; color:var(--gray-400); font-weight:600; }

/* ───────────────── MODAL ───────────────── */
.achievement-modal{
    position:fixed; inset:0;
    background:rgba(10,5,30,.65);
    backdrop-filter:blur(12px);
    display:none; align-items:center; justify-content:center;
    z-index:9999;
}

.modal-content{
    width:440px; background:white;
    border-radius:32px; padding:2.2rem 2rem 2rem;
    position:relative; overflow:hidden;
    text-align:center;
    box-shadow:0 30px 80px rgba(108,76,241,.28);
    animation:popup .4s cubic-bezier(.34,1.56,.64,1);
}

@keyframes popup{
    from{ opacity:0; transform:translateY(40px) scale(.86); }
    to{   opacity:1; transform:translateY(0)    scale(1);   }
}

#confettiCanvas{
    position:absolute; inset:0;
    width:100%; height:100%;
    pointer-events:none;
    border-radius:32px; z-index:0;
}

.modal-inner{ position:relative; z-index:1; }

.modal-badge-wrap{
    position:relative; width:100px; height:100px;
    margin:0 auto .4rem;
    display:flex; align-items:center; justify-content:center;
}

.modal-badge{
    font-size:3.2rem; line-height:1;
    position:relative; z-index:2;
    animation:bounce-in .5s .15s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes bounce-in{
    from{ transform:scale(0) rotate(-20deg); }
    to{   transform:scale(1) rotate(0deg);   }
}

.modal-badge-ring{
    position:absolute; inset:-6px; border-radius:50%;
    border:3px solid transparent;
    border-top-color:#6C4CF1; border-right-color:#A586FF;
    animation:spin-ring 2s linear infinite;
}

.modal-sparkles{
    display:flex; justify-content:center;
    gap:1.2rem; font-size:1.1rem;
    color:#A586FF; margin:.5rem 0 .8rem;
    animation:sparkle-pop .5s .35s ease both;
}
@keyframes sparkle-pop{
    from{ opacity:0; transform:scale(.4); }
    to{   opacity:1; transform:scale(1);  }
}
.modal-sparkles span:nth-child(2){ color:#6C4CF1; font-size:.8rem; }

.modal-title{
    font-size:1.7rem; font-weight:800;
    color:var(--gray-800); margin-bottom:.5rem;
}

.modal-desc{
    font-size:.9rem; color:var(--gray-400);
    line-height:1.7; margin-bottom:1.3rem;
}

.modal-reward{
    background:linear-gradient(135deg,#f5f0ff,#ede4ff);
    border:1px solid #ddd0ff;
    border-radius:20px; padding:1.1rem 1.2rem;
    margin-bottom:1.4rem; text-align:left;
}

.reward-label{ font-size:.72rem; color:var(--gray-400); margin-bottom:.3rem; font-weight:600; }
.reward-value{ font-size:1.1rem; font-weight:800; color:#6C4CF1; margin-bottom:.8rem; }

.xp-bar-track{
    height:8px; background:#e0d5ff;
    border-radius:10px; overflow:hidden; margin-bottom:.4rem;
}
.xp-bar-fill{
    height:100%;
    background:linear-gradient(90deg,#6C4CF1,#A586FF);
    border-radius:10px; width:0%;
    transition:width 1.2s cubic-bezier(.4,0,.2,1);
}
.xp-bar-labels{
    display:flex; justify-content:space-between;
    font-size:.68rem; color:var(--gray-400); font-weight:600;
}

.modal-close{
    width:100%; border:none;
    background:linear-gradient(135deg,#6C4CF1,#A586FF);
    color:white; font-family:var(--font);
    font-size:.92rem; font-weight:700;
    padding:1rem; border-radius:16px;
    cursor:pointer; transition:.25s;
    box-shadow:0 8px 24px rgba(108,76,241,.35);
}
.modal-close:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 36px rgba(108,76,241,.45);
}

/* ───────────────── RESPONSIVE ───────────────── */
@media(max-width:1024px){
    .stats-grid       { grid-template-columns:repeat(2,1fr); }
    .achievement-grid { grid-template-columns:repeat(2,1fr); }
}

@media(max-width:640px){
    .stats-grid,
    .achievement-grid { grid-template-columns:1fr; }
    .modal-content    { width:92%; padding:1.5rem; }
}

</style>
@endpush

@section('content')

<div class="progress-wrapper">

    <div class="progress-title">Progress Tracking</div>
    <div class="progress-subtitle">Pantau perkembangan belajarmu dari waktu ke waktu</div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stats-card">
            <div class="stats-top">
                <div class="stats-icon">📅</div>
                <span class="stats-badge badge-blue">↑ aktif</span>
            </div>
            <div class="stats-label">Total Hari Belajar</div>
            <div class="stats-number">89</div>
            <div class="stats-small">Sejak Jan 2026</div>
        </div>

        <div class="stats-card">
            <div class="stats-top">
                <div class="stats-icon">📚</div>
                <span class="stats-badge badge-green">↑ 18%</span>
            </div>
            <div class="stats-label">Materi Selesai</div>
            <div class="stats-number">239</div>
            <div class="stats-small">dari bulan lalu</div>
        </div>

        <div class="stats-card">
            <div class="stats-top">
                <div class="stats-icon">⏱️</div>
                <span class="stats-badge badge-green">↑ 12%</span>
            </div>
            <div class="stats-label">Total Jam Belajar</div>
            <div class="stats-number">265</div>
            <div class="stats-small">dari bulan lalu</div>
        </div>

        <div class="stats-card">
            <div class="stats-top">
                <div class="stats-icon">🏅</div>
                <span class="stats-badge badge-purple">6/20</span>
            </div>
            <div class="stats-label">Badge Earned</div>
            <div class="stats-number">6</div>
            <div class="stats-small">dari 20 badge</div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="chart-box">
        <div class="chart-title">Tren Belajar Bulanan</div>
        <div class="chart-sub">Materi selesai dan jam belajar per bulan</div>
        <div class="chart-wrapper" style="position:relative; height:300px;">
            <canvas id="progressChart"></canvas>
        </div>
    </div>

    {{-- ACHIEVEMENTS --}}
    <div class="achievement-box">

        <div class="achievement-title">🏆 Pencapaian</div>
        <div class="achievement-sub">Badge dan achievements yang sudah diraih</div>

        <div class="achievement-grid">

            {{-- 1 UNLOCKED --}}
            <div class="achievement-card"
                 onclick="openAchievement('⭐','First Step','Berhasil menyelesaikan materi pertama dan memulai perjalanan belajar di MappyPath!','100 XP + Beginner Badge',100,500)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(108,76,241,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap purple-wrap">
                    <div class="badge-emoji">⭐</div>
                    <div class="badge-ring"></div>
                </div>
                <div class="achievement-name">First Step</div>
                <div class="achievement-desc">Selesaikan materi pertama</div>
                <div class="achv-footer">
                    <span class="achv-xp">+100 XP</span>
                    <span class="achv-date">Jan 2026</span>
                </div>
            </div>

            {{-- 2 UNLOCKED --}}
            <div class="achievement-card"
                 onclick="openAchievement('🔥','Consistent','Kamu berhasil belajar selama 7 hari berturut-turut tanpa terputus. Luar biasa!','250 XP + Streak Bonus',250,500)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(229,75,122,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap pink-wrap">
                    <div class="badge-emoji">🔥</div>
                    <div class="badge-ring"></div>
                </div>
                <div class="achievement-name">Consistent</div>
                <div class="achievement-desc">Belajar 7 hari berturut-turut</div>
                <div class="achv-footer">
                    <span class="achv-xp">+250 XP</span>
                    <span class="achv-date">Jan 2026</span>
                </div>
            </div>

            {{-- 3 UNLOCKED --}}
            <div class="achievement-card"
                 onclick="openAchievement('🥉','Bronze Medal','Menyelesaikan 5 modul pembelajaran dengan progress yang konsisten. Terus semangat!','500 XP + Bronze Rank',500,1000)">
                <div class="card-shine"></div>
                <div class="card-glow" style="background:radial-gradient(circle at 65% 0%,rgba(205,127,50,.15),transparent 70%)"></div>
                <div class="achievement-badge-wrap bronze-wrap">
                    <div class="badge-emoji">🥉</div>
                    <div class="badge-ring"></div>
                </div>
                <div class="achievement-name">Bronze Medal</div>
                <div class="achievement-desc">Selesaikan 5 modul</div>
                <div class="achv-footer">
                    <span class="achv-xp">+500 XP</span>
                    <span class="achv-date">Jan 2026</span>
                </div>
            </div>

            {{-- 4 LOCKED --}}
            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap silver-wrap" style="opacity:.35">
                    <div class="badge-emoji">🥈</div>
                </div>
                <div class="achievement-name" style="opacity:.45">Silver Medal</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan 10 modul</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:50%"></div></div>
                <div class="locked-progress-text">5 / 10 modul</div>
            </div>

            {{-- 5 LOCKED --}}
            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap gold-wrap" style="opacity:.35">
                    <div class="badge-emoji">🥇</div>
                </div>
                <div class="achievement-name" style="opacity:.45">Gold Medal</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan 20 modul</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:25%"></div></div>
                <div class="locked-progress-text">5 / 20 modul</div>
            </div>

            {{-- 6 LOCKED --}}
            <div class="achievement-card locked-card">
                <div class="lock-overlay">🔒</div>
                <div class="achievement-badge-wrap green-wrap" style="opacity:.35">
                    <div class="badge-emoji">🏆</div>
                </div>
                <div class="achievement-name" style="opacity:.45">Winner</div>
                <div class="achievement-desc" style="opacity:.4">Selesaikan semua roadmap</div>
                <div class="locked-bar"><div class="locked-bar-fill" style="width:10%"></div></div>
                <div class="locked-progress-text">2 / 20 roadmap</div>
            </div>

        </div>

    </div>

</div>

{{-- MODAL --}}
<div class="achievement-modal" id="achievementModal" onclick="handleModalBg(event)">
    <div class="modal-content" id="modalBox">

        <canvas id="confettiCanvas"></canvas>

        <div class="modal-inner">

            <div class="modal-badge-wrap">
                <div class="modal-badge" id="modalEmoji">⭐</div>
                <div class="modal-badge-ring"></div>
            </div>

            <div class="modal-sparkles">
                <span>✦</span><span>✦</span><span>✦</span>
            </div>

            <div class="modal-title" id="modalTitle">First Step</div>
            <div class="modal-desc"  id="modalDesc">Deskripsi</div>

            <div class="modal-reward">
                <div class="reward-label">🎁 Reward yang didapat</div>
                <div class="reward-value" id="modalReward">100 XP</div>
                <div class="xp-bar-track">
                    <div class="xp-bar-fill" id="xpBarFill"></div>
                </div>
                <div class="xp-bar-labels">
                    <span>0 XP</span>
                    <span id="xpMax">1000 XP</span>
                </div>
            </div>

            <button class="modal-close" onclick="closeAchievement()">
                Keren! Tutup 🎉
            </button>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

/* ── Chart ── */
const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [
            {
                label: 'Materi selesai',
                data: [50, 60, 80, 65],
                borderColor: '#8B7BFF',
                backgroundColor: 'rgba(139,123,255,0.18)',
                fill: true, tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#8B7BFF',
                pointBorderWidth: 2,
            },
            {
                label: 'Jam belajar',
                data: [56, 68, 70, 90],
                borderColor: '#FFA69E',
                backgroundColor: 'rgba(255,166,158,0.15)',
                fill: true, tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#FFA69E',
                pointBorderWidth: 2,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { usePointStyle: true, padding: 20, font: { size: 12 } }
            }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#eee' } },
            x: { grid: { color: '#f5f5f5' } }
        }
    }
});

/* ── Confetti ── */
let confettiAnim;
const COLORS = ['#6C4CF1','#A586FF','#ff8fab','#FFA69E','#FFD166','#06D6A0'];

function launchConfetti(){
    const canvas  = document.getElementById('confettiCanvas');
    const box     = document.getElementById('modalBox');
    canvas.width  = box.offsetWidth;
    canvas.height = box.offsetHeight;
    const c       = canvas.getContext('2d');
    const pieces  = Array.from({length:80}, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 3,
        d: Math.random() * 4 + 2,
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        tilt: Math.random() * 10 - 5,
        tiltAngle: 0,
        tiltSpeed: Math.random() * .1 + .05,
    }));

    let frame = 0;
    function draw(){
        c.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(p => {
            p.tiltAngle += p.tiltSpeed;
            p.y += p.d;
            p.tilt = Math.sin(p.tiltAngle) * 12;
            if(p.y > canvas.height){ p.y = -10; p.x = Math.random() * canvas.width; }
            c.beginPath();
            c.lineWidth = p.r;
            c.strokeStyle = p.color;
            c.moveTo(p.x + p.tilt + p.r / 2, p.y);
            c.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2);
            c.stroke();
        });
        frame++;
        if(frame < 180) confettiAnim = requestAnimationFrame(draw);
        else c.clearRect(0,0,canvas.width,canvas.height);
    }
    draw();
}

/* ── Modal ── */
function openAchievement(icon, title, desc, reward, xp, xpMax){
    document.getElementById('achievementModal').style.display = 'flex';
    document.getElementById('modalEmoji').innerText   = icon;
    document.getElementById('modalTitle').innerText   = title;
    document.getElementById('modalDesc').innerText    = desc;
    document.getElementById('modalReward').innerText  = reward;
    document.getElementById('xpMax').innerText        = xpMax + ' XP';

    /* reset & animate XP bar */
    const bar = document.getElementById('xpBarFill');
    bar.style.width = '0%';
    setTimeout(() => {
        bar.style.width = Math.min((xp / xpMax) * 100, 100) + '%';
    }, 300);

    /* confetti */
    cancelAnimationFrame(confettiAnim);
    setTimeout(launchConfetti, 200);
}

function closeAchievement(){
    cancelAnimationFrame(confettiAnim);
    document.getElementById('achievementModal').style.display = 'none';
}

function handleModalBg(e){
    if(e.target === document.getElementById('achievementModal')) closeAchievement();
}

</script>
@endpush