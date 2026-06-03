<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roadmap;
use App\Models\Stage;
use App\Models\UserRoadmap;
use App\Models\UserStage;
use App\Models\Target;
use App\Models\Badge;
use App\Models\LearningLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // USERS
        // ==========================================
        $user = User::create([
            'name'     => 'Gema Pelajar',
            'username' => 'tupaikidal',
            'email'    => 'tupaikidal@mappypath.id',
            'password' => Hash::make('Kambingguling_001'),
            'role'     => 'student',
        ]);

        User::create([
            'name'     => 'Admin MappyPath',
            'username' => 'admin',
            'email'    => 'admin@mappypath.id',
            'password' => Hash::make('Admin@123'),
            'role'     => 'admin',
        ]);

        // ==========================================
        // ROADMAP 1 - Pengenalan Jaringan Komputer (beginner) - CP 4
        // ==========================================
        $r1 = Roadmap::create([
            'title'           => 'Pengenalan Jaringan Komputer',
            'description'     => 'Tahap awal TKJ: pengenalan perangkat jaringan dan cara kerja jaringan dasar (CP 4).',
            'slug'            => 'pengenalan-jaringan-komputer',
            'level'           => 'beginner',
            'category'        => 'networking',
            'total_stages'    => 4,
            'estimated_hours' => 16,
            'order'           => 1,
        ]);

        $s1data = [
            // [group_label, title, description, url, menit, learning_points]
            [
                'Dasar Jaringan Komputer',
                'Pengertian dan Jenis Jaringan Komputer',
                'Memahami apa itu jaringan komputer, manfaatnya, dan mengenal LAN, MAN, dan WAN beserta perbedaannya.',
                'https://youtu.be/WPhjxoVDygk?si=_BTGBhRiU0nsRp4J',
                10,
                "Definisi jaringan komputer\nManfaat jaringan\nKomponen dasar jaringan\nContoh jaringan sehari-hari\nLAN (Local Area Network)\nMAN (Metropolitan Area Network)\nWAN (Wide Area Network)\nPerbandingan jangkauan dan penggunaan",
            ],
            [
                'Dasar Jaringan Komputer',
                'Topologi Jaringan',
                'Mengenal berbagai topologi jaringan dan penerapannya.',
                'https://youtu.be/lRNcZEgWrw4?si=N2Ww75bt7n4MjqsT',
                15,
                "Topologi Bus\nTopologi Star\nTopologi Ring\nTopologi Mesh\nKelebihan dan kekurangan tiap topologi",
            ],
            [
                'Perangkat Jaringan',
                'Pengenalan Perangkat Jaringan',
                'Mengenal router, switch, hub, access point, dan modem.',
                'https://youtu.be/N2CNS1N9gZo?si=cltK03mgv5hHY_ue',
                15,
                "Router dan fungsinya\nSwitch vs Hub\nAccess Point\nModem\nPerbedaan fungsi antar perangkat",
            ],
            [
                'Perangkat Jaringan',
                'Fungsi dan Cara Kerja Perangkat Jaringan',
                'Memahami cara kerja masing-masing perangkat jaringan.',
                'https://youtu.be/jokDcCuMABY?si=tPDrIDtOddhZ2LlO',
                20,
                "Cara kerja router\nCara kerja switch\nCara kerja access point\nSkenario jaringan sederhana",
            ],

        ];

        $stageIds1 = [];
        foreach ($s1data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r1->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds1[] = $st->id;
        }
        $r1->update(['total_stages' => count($stageIds1)]);

        // ==========================================
        // ROADMAP 2 - Konsep Jaringan & Komunikasi Data (intermediate) - CP 6
        // ==========================================
        $r2 = Roadmap::create([
            'title'           => 'Konsep Jaringan & Komunikasi Data',
            'description'     => 'Tahap inti TKJ: model OSI, TCP/IP, pengalamatan IP, subnetting, dan keamanan jaringan dasar (CP 6).',
            'slug'            => 'konsep-jaringan-komunikasi-data',
            'level'           => 'intermediate',
            'category'        => 'networking',
            'total_stages'    => 13,
            'estimated_hours' => 45,
            'order'           => 2,
        ]);

        $s2data = [
            [
                'Konsep Dasar Jaringan',
                'Model OSI Layer',
                'Memahami 7 lapisan OSI Model dan fungsi tiap lapisan.',
                'https://youtu.be/vv4y_uOneC0?si=JF1v5GZ2Q8R9X5YV',
                20,
                "7 lapisan OSI\nFungsi setiap lapisan\nAlur pengiriman data\nEncapsulation & Decapsulation",
            ],
            [
                'Konsep Dasar Jaringan',
                'TCP/IP Model',
                'Memahami model TCP/IP sebagai dasar komunikasi internet.',
                'https://www.youtube.com/watch?v=OTwp3xtd4dg',
                15,
                "4 lapisan TCP/IP\nPerbandingan OSI vs TCP/IP\nBagaimana internet bekerja\nProtokol tiap lapisan",
            ],
            [
                'Konsep Dasar Jaringan',
                'Encapsulation & Alur Data',
                'Memahami proses enkapsulasi dan alur pengiriman data di jaringan.',
                'https://www.youtube.com/watch?v=vv4y_uOneC0',
                15,
                "Proses encapsulation\nProses decapsulation\nPDU (Protocol Data Unit)\nAlur data end-to-end",
            ],
            [
                'Komunikasi Data',
                'Mode Komunikasi Data',
                'Mengenal simplex, half duplex, dan full duplex.',
                'https://www.youtube.com/watch?v=H7-NR3Q3BeI',
                12,
                "Simplex\nHalf Duplex\nFull Duplex\nContoh penggunaan nyata",
            ],
            [
                'Komunikasi Data',
                'Media Transmisi & Bandwidth',
                'Jenis media transmisi data dan konsep bandwidth.',
                'https://www.youtube.com/watch?v=H7-NR3Q3BeI',
                12,
                "Media kabel (UTP, Fiber)\nMedia nirkabel\nPengertian bandwidth\nLatency dan throughput",
            ],
            [
                'Protokol Jaringan',
                'Protokol TCP & UDP',
                'Perbedaan TCP dan UDP serta penggunaannya.',
                'https://www.youtube.com/watch?v=OTwp3xtd4dg',
                15,
                "Cara kerja TCP\nCara kerja UDP\nPerbedaan TCP vs UDP\nKapan menggunakan masing-masing",
            ],
            [
                'Protokol Jaringan',
                'Protokol HTTP, DNS, dan DHCP',
                'Memahami protokol aplikasi yang sering digunakan.',
                'https://www.youtube.com/watch?v=OTwp3xtd4dg',
                15,
                "Cara kerja HTTP/HTTPS\nProses resolusi DNS\nCara kerja DHCP\nPort number protokol",
            ],
            [
                'Pengalamatan IP',
                'IP Address IPv4',
                'Konsep dasar pengalamatan IP versi 4.',
                'https://www.youtube.com/watch?v=ddM9AcreVqY',
                18,
                "Format IPv4\nKelas IP (A, B, C, D, E)\nNetwork ID dan Host ID\nIP Private vs Public",
            ],
            [
                'Pengalamatan IP',
                'Subnet Mask & CIDR',
                'Memahami subnet mask dan notasi CIDR.',
                'https://www.youtube.com/watch?v=ddM9AcreVqY',
                15,
                "Fungsi subnet mask\nNotasi CIDR\nDefault subnet tiap kelas\nContoh penerapan",
            ],
            [
                'Pengalamatan IP',
                'Subnetting Jaringan',
                'Teknik menghitung dan membagi subnet.',
                'https://www.youtube.com/watch?v=ecCuyq-Wprc',
                25,
                "Konsep subnetting\nMenghitung jumlah subnet\nMenghitung jumlah host\nNetwork & Broadcast address\nRange IP yang valid",
            ],
            [
                'Pengalamatan IP',
                'Latihan Soal Subnetting',
                'Praktik menyelesaikan soal subnetting.',
                'https://www.youtube.com/watch?v=ecCuyq-Wprc',
                25,
                "Soal subnetting class C\nSoal subnetting class B\nMenentukan network address\nMenentukan broadcast address\nRange IP valid",
            ],
            [
                'Keamanan Jaringan Dasar',
                'Ancaman Keamanan Jaringan',
                'Mengenal jenis ancaman keamanan jaringan.',
                'https://www.youtube.com/watch?v=sWbUDq4S6Y8',
                15,
                "Jenis-jenis malware\nSerangan jaringan umum\nPhishing dan social engineering\nDampak serangan siber",
            ],
            [
                'Keamanan Jaringan Dasar',
                'Konsep Keamanan & Firewall',
                'Dasar-dasar pengamanan jaringan.',
                'https://www.youtube.com/watch?v=sWbUDq4S6Y8',
                15,
                "Fungsi firewall\nPassword security\nPrinsip CIA (Confidentiality, Integrity, Availability)\nBest practice keamanan",
            ],
        ];

        $stageIds2 = [];
        foreach ($s2data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r2->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds2[] = $st->id;
        }
        $r2->update(['total_stages' => count($stageIds2)]);

        // ==========================================
        // ROADMAP 3 - Administrasi Server Linux (advanced)
        // ==========================================
        $r3 = Roadmap::create([
            'title'           => 'Administrasi Server Linux',
            'description'     => 'Kuasai administrasi server Linux untuk dunia kerja teknisi jaringan.',
            'slug'            => 'administrasi-server-linux',
            'level'           => 'advanced',
            'category'        => 'server',
            'total_stages'    => 6,
            'estimated_hours' => 40,
            'order'           => 3,
        ]);

        $s3data = [
            [
                'Dasar Linux',
                'Pengenalan Linux',
                'Mengenal sistem operasi Linux dan instalasi Ubuntu.',
                'https://www.youtube.com/watch?v=sWbUDq4S6Y8',
                20,
                "Sejarah Linux\nDistribusi Linux (Ubuntu, CentOS, Debian)\nLinux vs Windows\nInstalasi Ubuntu Server",
            ],
            [
                'Dasar Linux',
                'Command Line Linux',
                'Menguasai perintah dasar terminal Linux.',
                'https://www.youtube.com/watch?v=IVquJh3DXUA',
                30,
                "Navigasi direktori (ls, cd, pwd)\nManajemen file (cp, mv, rm, mkdir)\nPermission dan ownership\nPipe dan redirect",
            ],
            [
                'Administrasi Server',
                'Manajemen User & Group',
                'Mengelola user, group, dan hak akses di Linux.',
                'https://www.youtube.com/watch?v=jwnvKOjmtEA',
                25,
                "Membuat dan menghapus user\nManajemen group\nHak akses sudo dan root\nPermission rwx (chmod, chown)",
            ],
            [
                'Administrasi Server',
                'Instalasi & Konfigurasi Web Server',
                'Instalasi Apache dan konfigurasi virtual host.',
                'https://www.youtube.com/watch?v=1CDxpAzvLKY',
                35,
                "Instalasi Apache2\nKonfigurasi Virtual Host\nManajemen service (start, stop, restart)\nUji coba web server",
            ],
            [
                'Jaringan Linux',
                'Konfigurasi Jaringan di Linux',
                'Mengatur IP statis, DNS, SSH, dan firewall.',
                'https://www.youtube.com/watch?v=XbxFHRPzDuc',
                30,
                "Konfigurasi IP statis\nPengaturan DNS dan hostname\nFirewall dengan UFW\nAkses remote via SSH",
            ],
            [
                'Jaringan Linux',
                'Backup, Monitoring & Troubleshooting',
                'Strategi backup, monitoring server, dan troubleshooting dasar.',
                'https://www.youtube.com/watch?v=1ehpCssFAYI',
                30,
                "Strategi backup data\nOtomasi dengan cron job\nMonitoring dengan htop dan df\nAnalisis log server\nTroubleshooting koneksi",
            ],
        ];

        $stageIds3 = [];
        foreach ($s3data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r3->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds3[] = $st->id;
        }
        $r3->update(['total_stages' => count($stageIds3)]);

        // ==========================================
        // ROADMAP 4 - Proses Bisnis & Teknologi Jaringan Modern (advanced) - CP 1 & CP 2
        // ==========================================
        $r4 = Roadmap::create([
            'title'           => 'Proses Bisnis & Teknologi Jaringan Modern',
            'description'     => 'Tahap akhir TKJ: proses bisnis, peran teknisi, cloud computing, IoT, dan virtualisasi (CP 1 & CP 2).',
            'slug'            => 'proses-bisnis-teknologi-jaringan',
            'level'           => 'advanced',
            'category'        => 'networking',
            'total_stages'    => 6,
            'estimated_hours' => 20,
            'order'           => 4,
        ]);

        $s4data = [
            [
                'Proses Bisnis Jaringan',
                'Alur Kerja Teknisi Jaringan',
                'Memahami peran dan alur kerja seorang teknisi jaringan di dunia industri.',
                'https://www.youtube.com/watch?v=sWbUDq4S6Y8',
                20,
                "Peran teknisi jaringan\nAlur kerja di industri\nDokumentasi jaringan\nKomunikasi dengan klien",
            ],
            [
                'Proses Bisnis Jaringan',
                'Maintenance Jaringan',
                'Prosedur perawatan dan pemeliharaan jaringan.',
                'https://www.youtube.com/watch?v=1ehpCssFAYI',
                20,
                "Jadwal maintenance\nPengecekan performa jaringan\nUpdate firmware perangkat\nDokumentasi hasil maintenance",
            ],
            [
                'Proses Bisnis Jaringan',
                'Troubleshooting Jaringan',
                'Metode sistematis dalam menyelesaikan masalah jaringan.',
                'https://www.youtube.com/watch?v=IVquJh3DXUA',
                25,
                "Metode troubleshooting\nTools: ping, traceroute, ipconfig\nIdentifikasi masalah umum\nEskalasi masalah",
            ],
            [
                'Teknologi Masa Depan',
                'Cloud Computing',
                'Mengenal konsep dan layanan cloud computing.',
                'https://www.youtube.com/watch?v=M988_fsOSWo',
                20,
                "Pengertian cloud computing\nModel layanan: IaaS, PaaS, SaaS\nCloud publik vs privat\nContoh: AWS, GCP, Azure",
            ],
            [
                'Teknologi Masa Depan',
                'Internet of Things (IoT)',
                'Konsep IoT dan penerapannya dalam kehidupan nyata.',
                'https://www.youtube.com/watch?v=LlhmzVL5bm8',
                20,
                "Pengertian IoT\nKomponen sistem IoT\nProtokol IoT (MQTT)\nContoh implementasi IoT",
            ],
            [
                'Teknologi Masa Depan',
                'Virtualisasi Jaringan',
                'Konsep virtualisasi dan penerapannya di jaringan modern.',
                'https://www.youtube.com/watch?v=FZR0rG3HKIk',
                20,
                "Pengertian virtualisasi\nVirtual Machine (VM)\nHypervisor tipe 1 dan 2\nManfaat virtualisasi di jaringan",
            ],
        ];

        $stageIds4 = [];
        foreach ($s4data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r4->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds4[] = $st->id;
        }
        $r4->update(['total_stages' => count($stageIds4)]);

        // ==========================================
        // ROADMAP 5 - Cisco Networking CCNA (advanced)
        // ==========================================
        $r5 = Roadmap::create([
            'title'           => 'Cisco Networking (CCNA)',
            'description'     => 'Persiapan sertifikasi CCNA: VLAN, Routing, ACL, dan NAT pada perangkat Cisco.',
            'slug'            => 'cisco-networking-ccna',
            'level'           => 'advanced',
            'category'        => 'networking',
            'total_stages'    => 5,
            'estimated_hours' => 60,
            'order'           => 5,
        ]);

        $s5data = [
            [
                'VLAN & Switching',
                'Konfigurasi VLAN',
                'Memahami dan mengkonfigurasi VLAN pada switch Cisco.',
                'https://www.youtube.com/watch?v=MmwF1oHOvmg',
                35,
                "Konsep dan manfaat VLAN\nKonfigurasi VLAN di Cisco\nTrunk port (802.1Q)\nInter-VLAN routing",
            ],
            [
                'VLAN & Switching',
                'Spanning Tree Protocol (STP)',
                'Memahami STP untuk mencegah loop pada jaringan switched.',
                'https://www.youtube.com/watch?v=japdEY1UKe4',
                30,
                "Masalah broadcast loop\nCara kerja STP\nPemilihan Root Bridge\nRSTP dan PVST+",
            ],
            [
                'Routing',
                'Static & Dynamic Routing',
                'Konfigurasi routing statis dan dinamis pada router Cisco.',
                'https://www.youtube.com/watch?v=Ep-x_6kggKA',
                40,
                "Static routing\nDynamic routing dengan RIP\nOSPF dasar\nBGP overview",
            ],
            [
                'Security',
                'Access Control List (ACL)',
                'Mengamankan jaringan menggunakan ACL pada Cisco.',
                'https://www.youtube.com/watch?v=fBCof0HO-1s',
                35,
                "Standard ACL\nExtended ACL\nNamed ACL\nPenerapan keamanan jaringan",
            ],
            [
                'Security',
                'NAT & PAT Configuration',
                'Konfigurasi translasi alamat IP dengan NAT dan PAT.',
                'https://www.youtube.com/watch?v=wg8Hosr20yw',
                30,
                "Konsep NAT\nStatic dan Dynamic NAT\nPAT (Port Address Translation)\nKonfigurasi di Cisco IOS",
            ],
        ];

        $stageIds5 = [];
        foreach ($s5data as $i => $s) {
            $st = Stage::create([
                'roadmap_id'        => $r5->id,
                'group_label'       => $s[0],
                'title'             => $s[1],
                'description'       => $s[2],
                'content_url'       => $s[3],
                'type'              => 'video',
                'estimated_minutes' => $s[4],
                'learning_points'   => $s[5],
                'order'             => $i + 1,
                'is_active'         => true,
            ]);
            $stageIds5[] = $st->id;
        }
        $r5->update(['total_stages' => count($stageIds5)]);

        // ==========================================
        // ENROLLMENT - User ke R1 (aktif, sedang berjalan)
        // ==========================================
        UserRoadmap::create([
            'user_id'    => $user->id,
            'roadmap_id' => $r1->id,
            'progress'   => 50,           // 3 dari 6 stage selesai = 50%
            'status'     => 'active',
            'started_at' => now()->subWeeks(2),
        ]);

        // 3 stage pertama r1 sudah diselesaikan user
        foreach (array_slice($stageIds1, 0, 3) as $i => $sid) {
            UserStage::create([
                'user_id'             => $user->id,
                'stage_id'            => $sid,
                'roadmap_id'          => $r1->id,
                'is_completed'        => true,
                'completed_at'        => now()->subDays(12 - ($i * 3)),
                'time_spent_minutes'  => rand(15, 35),
            ]);
        }

        // ==========================================
        // TARGETS
        // ==========================================
        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Selesaikan Pengenalan Jaringan Komputer',
            'type'          => 'custom',
            'target_value'  => 6,
            'current_value' => 3,
            'deadline'      => now()->addDays(20)->toDateString(),
            'status'        => 'active',
        ]);

        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Belajar 5 materi per minggu',
            'type'          => 'weekly',
            'target_value'  => 5,
            'current_value' => 4,
            'deadline'      => now()->endOfWeek()->toDateString(),
            'status'        => 'active',
        ]);

        Target::create([
            'user_id'       => $user->id,
            'name'          => 'Raih 10 Badge',
            'type'          => 'custom',
            'target_value'  => 10,
            'current_value' => 12,
            'deadline'      => null,
            'status'        => 'done',
        ]);

        // ==========================================
        // BADGES
        // ==========================================
        $badgesData = [
            ['Pemula',       '🌱', '#22c55e', 'stages_done',  1],
            ['Rajin Belajar','📚', '#3b82f6', 'stages_done', 10],
            ['Streak 7 Hari','🔥', '#f97316', 'streak',       7],
            ['Road Master',  '🏆', '#f59e0b', 'roadmap_done', 1],
            ['Networker',    '🌐', '#372466', 'stages_done',  5],
            ['Konsisten',    '⭐', '#8b5cf6', 'streak',       30],
        ];

        foreach ($badgesData as $b) {
            $badge = Badge::create([
                'name'            => $b[0],
                'icon'            => $b[1],
                'color'           => $b[2],
                'condition_type'  => $b[3],
                'condition_value' => $b[4],
                'description'     => "Badge {$b[0]}",
            ]);

            // 4 badge pertama sudah diraih user
            if ($badge->id <= 4) {
                $user->badges()->attach($badge->id, [
                    'earned_at' => now()->subDays(rand(1, 20)),
                ]);
            }
        }

        // ==========================================
        // LEARNING LOGS - 20 entri aktivitas belajar
        // ==========================================
        for ($i = 0; $i < 20; $i++) {
            LearningLog::create([
                'user_id'          => $user->id,
                'roadmap_id'       => $r1->id,
                'stage_id'         => $stageIds1[array_rand($stageIds1)],
                'duration_minutes' => rand(15, 45),
                'log_date'         => now()->subDays(rand(0, 27))->toDateString(),
                'activity'         => ['study', 'review'][rand(0, 1)],
            ]);
        }
    }
}