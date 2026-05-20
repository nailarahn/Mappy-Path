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
        // USERS
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

        // ROADMAP 1 - Jaringan Dasar TKJ (beginner)
        $r1 = Roadmap::create([
            'title' => 'Jaringan Dasar TKJ', 'description' => 'Pelajari dasar jaringan komputer.',
            'slug' => 'jaringan-dasar-tkj', 'level' => 'beginner', 'category' => 'networking',
            'total_stages' => 9, 'estimated_hours' => 24, 'order' => 1,
        ]);

        $s1data = [
            ['Pengenalan Jaringan Komputer','Apa Itu Jaringan Komputer?','Memahami konsep dasar jaringan komputer.','https://www.youtube.com/watch?v=3QhU9jd03a0',7,"Definisi jaringan komputer\nManfaat jaringan\nKomponen dasar\nPerbedaan LAN WAN MAN"],
            ['Pengenalan Jaringan Komputer','Jenis-jenis Jaringan','Mengenal berbagai jenis jaringan.','https://www.youtube.com/watch?v=H7-NR3Q3BeI',8,"LAN MAN WAN\nTopologi dasar\nMedia transmisi\nWired vs wireless"],
            ['Pengenalan Jaringan Komputer','Topologi Jaringan','Berbagai topologi jaringan.','https://www.youtube.com/watch?v=zbqrNg4C98U',12,"Topologi Bus Star Ring\nKelebihan kekurangan\nPemilihan topologi\nImplementasi nyata"],
            ['OSI Model','Pengenalan OSI Model','7 lapisan OSI Model.','https://www.youtube.com/watch?v=vv4y_uOneC0',15,"7 lapisan OSI\nFungsi setiap lapisan\nAlur data OSI\nOSI vs TCP/IP"],
            ['OSI Model','TCP/IP Model','TCP/IP model dasar internet.','https://www.youtube.com/watch?v=OTwp3xtd4dg',12,"4 lapisan TCP/IP\nProtokol penting\nBagaimana internet bekerja\nHubungan TCP/IP OSI"],
            ['IP Addressing','IP Address Dasar','Konsep IP Address.','https://www.youtube.com/watch?v=ddM9AcreVqY',18,"Format IPv4\nKelas IP A B C\nIP Private vs Public\nSubnet Mask"],
            ['IP Addressing','Subnetting','Teknik subnetting jaringan.','https://www.youtube.com/watch?v=ecCuyq-Wprc',20,"Konsep subnetting\nCIDR notation\nCara menghitung subnet\nContoh subnetting"],
            ['Perangkat Jaringan','Switch dan Router','Fungsi Switch dan Router.','https://www.youtube.com/watch?v=1z0ULvg_pW8',15,"Perbedaan Hub Switch Router\nCara kerja Switch\nCara kerja Router\nPerangkat yang tepat"],
            ['Perangkat Jaringan','Konfigurasi Jaringan Sederhana','Praktek konfigurasi jaringan.','https://www.youtube.com/watch?v=Ybe3sXZCpnk',30,"Instalasi Packet Tracer\nMembuat topologi\nKonfigurasi IP\nUji koneksi ping"],
        ];

        $stageIds1 = [];
        foreach ($s1data as $i => $s) {
            $st = Stage::create([
                'roadmap_id' => $r1->id, 'group_label' => $s[0], 'title' => $s[1],
                'description' => $s[2], 'content_url' => $s[3], 'type' => 'video',
                'estimated_minutes' => $s[4], 'learning_points' => $s[5],
                'order' => $i+1, 'is_active' => true,
            ]);
            $stageIds1[] = $st->id;
        }
        $r1->update(['total_stages' => count($stageIds1)]);

        // ROADMAP 2 - Pemrograman Web Dasar (beginner)
        $r2 = Roadmap::create([
            'title' => 'Pemrograman Web Dasar', 'description' => 'Belajar HTML, CSS, JavaScript.',
            'slug' => 'pemrograman-web-dasar', 'level' => 'beginner', 'category' => 'programming',
            'total_stages' => 6, 'estimated_hours' => 30, 'order' => 2,
        ]);

        $s2data = [
            ['HTML & CSS','HTML Dasar','Struktur dasar HTML.','https://www.youtube.com/watch?v=it1rTvBcfRg',20,"Struktur HTML\nTag penting\nTeks dan link\nGambar dan tabel"],
            ['HTML & CSS','CSS Dasar','Mempercantik tampilan web.','https://www.youtube.com/watch?v=wRNinF7YQqQ',25,"Selector CSS\nWarna dan font\nBox model\nFlexbox"],
            ['JavaScript','JavaScript Dasar','Website interaktif.','https://www.youtube.com/watch?v=hdI2bqOjy3c',30,"Variabel dan tipe data\nFungsi kondisi\nManipulasi DOM\nEvent handling"],
            ['JavaScript','Responsive Web Design','Website di semua perangkat.','https://www.youtube.com/watch?v=srvUrASNj0s',20,"Media query\nFlexbox Grid\nMobile-first\nBootstrap"],
            ['PHP & MySQL','PHP Dasar','Web dinamis dengan PHP.','https://www.youtube.com/watch?v=oJbfyzaA2QA',35,"Sintaks PHP\nVariabel array\nFunction loop\nKoneksi MySQL"],
            ['PHP & MySQL','MySQL Dasar','Mengelola data dengan MySQL.','https://www.youtube.com/watch?v=7S_tz1z_5bA',25,"Perintah SQL\nCRUD\nRelasi tabel\nQuery lanjutan"],
        ];

        foreach ($s2data as $i => $s) {
            Stage::create([
                'roadmap_id' => $r2->id, 'group_label' => $s[0], 'title' => $s[1],
                'description' => $s[2], 'content_url' => $s[3], 'type' => 'video',
                'estimated_minutes' => $s[4], 'learning_points' => $s[5],
                'order' => $i+1, 'is_active' => true,
            ]);
        }
        $r2->update(['total_stages' => count($s2data)]);

        // ROADMAP 3 - Administrasi Server Linux (intermediate)
        $r3 = Roadmap::create([
            'title' => 'Administrasi Server Linux', 'description' => 'Kuasai administrasi server Linux.',
            'slug' => 'administrasi-server-linux', 'level' => 'intermediate', 'category' => 'server',
            'total_stages' => 6, 'estimated_hours' => 40, 'order' => 3,
        ]);

        $s3data = [
            ['Dasar Linux','Pengenalan Linux','Sistem operasi Linux.','https://www.youtube.com/watch?v=sWbUDq4S6Y8',20,"Sejarah Linux\nDistribusi Linux\nLinux vs Windows\nInstalasi Ubuntu"],
            ['Dasar Linux','Command Line Linux','Perintah dasar terminal.','https://www.youtube.com/watch?v=IVquJh3DXUA',30,"Navigasi direktori\nManajemen file\nPermission\nPipe redirect"],
            ['Administrasi Server','Manajemen User Linux','User dan hak akses.','https://www.youtube.com/watch?v=jwnvKOjmtEA',25,"Membuat user\nManajemen group\nSudo root\nPermission rwx"],
            ['Administrasi Server','Instalasi Web Server','Apache di Linux.','https://www.youtube.com/watch?v=1CDxpAzvLKY',35,"Instalasi Apache\nVirtual Host\nManajemen service\nUji web server"],
            ['Jaringan Linux','Konfigurasi Jaringan Linux','Jaringan di server Linux.','https://www.youtube.com/watch?v=XbxFHRPzDuc',30,"IP statis\nDNS hostname\nFirewall UFW\nSSH remote"],
            ['Jaringan Linux','Backup dan Monitoring','Backup dan monitoring server.','https://www.youtube.com/watch?v=1ehpCssFAYI',25,"Strategi backup\nCron job\nMonitoring htop\nLog server"],
        ];

        foreach ($s3data as $i => $s) {
            Stage::create([
                'roadmap_id' => $r3->id, 'group_label' => $s[0], 'title' => $s[1],
                'description' => $s[2], 'content_url' => $s[3], 'type' => 'video',
                'estimated_minutes' => $s[4], 'learning_points' => $s[5],
                'order' => $i+1, 'is_active' => true,
            ]);
        }
        $r3->update(['total_stages' => count($s3data)]);

        // ROADMAP 4 - Cisco CCNA (advanced)
        $r4 = Roadmap::create([
            'title' => 'Cisco Networking (CCNA)', 'description' => 'Persiapan sertifikasi CCNA.',
            'slug' => 'cisco-networking-ccna', 'level' => 'advanced', 'category' => 'networking',
            'total_stages' => 5, 'estimated_hours' => 60, 'order' => 4,
        ]);

        $s4data = [
            ['VLAN & Switching','VLAN Configuration','Konfigurasi VLAN Cisco.','https://www.youtube.com/watch?v=MmwF1oHOvmg',35,"Konsep VLAN\nKonfigurasi VLAN\nTrunk port\nInter-VLAN routing"],
            ['VLAN & Switching','Spanning Tree Protocol','STP mencegah loop.','https://www.youtube.com/watch?v=japdEY1UKe4',30,"Masalah loop\nCara kerja STP\nRoot bridge\nRSTP PVST+"],
            ['Routing','Static dan Dynamic Routing','Routing Cisco.','https://www.youtube.com/watch?v=Ep-x_6kggKA',40,"Static routing\nRIP dynamic\nOSPF dasar\nBGP overview"],
            ['Security','ACL Configuration','Access Control List.','https://www.youtube.com/watch?v=fBCof0HO-1s',35,"Standard ACL\nExtended ACL\nNamed ACL\nKeamanan jaringan"],
            ['Security','NAT & PAT Configuration','Translasi IP address.','https://www.youtube.com/watch?v=wg8Hosr20yw',30,"Konsep NAT\nStatic Dynamic NAT\nPAT Overload\nKonfigurasi Cisco IOS"],
        ];

        foreach ($s4data as $i => $s) {
            Stage::create([
                'roadmap_id' => $r4->id, 'group_label' => $s[0], 'title' => $s[1],
                'description' => $s[2], 'content_url' => $s[3], 'type' => 'video',
                'estimated_minutes' => $s[4], 'learning_points' => $s[5],
                'order' => $i+1, 'is_active' => true,
            ]);
        }
        $r4->update(['total_stages' => count($s4data)]);

        // ENROLLMENT user ke roadmap 1
        UserRoadmap::create([
            'user_id' => $user->id, 'roadmap_id' => $r1->id,
            'progress' => 33, 'status' => 'active', 'started_at' => now()->subWeeks(2),
        ]);

        foreach (array_slice($stageIds1, 0, 3) as $i => $sid) {
            UserStage::create([
                'user_id' => $user->id, 'stage_id' => $sid, 'roadmap_id' => $r1->id,
                'is_completed' => true, 'completed_at' => now()->subDays(12 - ($i * 3)),
                'time_spent_minutes' => rand(15, 35),
            ]);
        }

        // TARGETS
        Target::create(['user_id'=>$user->id,'name'=>'Selesaikan Jaringan Dasar TKJ','type'=>'custom','target_value'=>9,'current_value'=>3,'deadline'=>now()->addDays(20)->toDateString(),'status'=>'active']);
        Target::create(['user_id'=>$user->id,'name'=>'Belajar 5 materi per minggu','type'=>'weekly','target_value'=>5,'current_value'=>4,'deadline'=>now()->endOfWeek()->toDateString(),'status'=>'active']);
        Target::create(['user_id'=>$user->id,'name'=>'Raih 10 Badge','type'=>'custom','target_value'=>10,'current_value'=>12,'deadline'=>null,'status'=>'done']);

        // BADGES
        foreach ([
            ['Pemula','🌱','#22c55e','stages_done',1],
            ['Rajin Belajar','📚','#3b82f6','stages_done',10],
            ['Streak 7 Hari','🔥','#f97316','streak',7],
            ['Road Master','🏆','#f59e0b','roadmap_done',1],
            ['Networker','🌐','#372466','stages_done',5],
            ['Konsisten','⭐','#8b5cf6','streak',30],
        ] as $b) {
            $badge = Badge::create(['name'=>$b[0],'icon'=>$b[1],'color'=>$b[2],'condition_type'=>$b[3],'condition_value'=>$b[4],'description'=>"Badge {$b[0]}"]);
            if ($badge->id <= 4) $user->badges()->attach($badge->id, ['earned_at'=>now()->subDays(rand(1,20))]);
        }

        // LEARNING LOGS
        for ($i = 0; $i < 20; $i++) {
            LearningLog::create([
                'user_id' => $user->id, 'roadmap_id' => $r1->id,
                'stage_id' => $stageIds1[array_rand($stageIds1)],
                'duration_minutes' => rand(15, 45),
                'log_date' => now()->subDays(rand(0, 27))->toDateString(),
                'activity' => ['study','review'][rand(0,1)],
            ]);
        }
    }
}
