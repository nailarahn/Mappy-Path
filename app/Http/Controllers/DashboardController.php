<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $progressData = [
            ['minggu' => 'Minggu 1', 'progress' => 60],
            ['minggu' => 'Minggu 2', 'progress' => 50],
            ['minggu' => 'Minggu 3', 'progress' => 80],
            ['minggu' => 'Minggu 4', 'progress' => 90],
        ];

        $recommendations = [
            ['title' => 'IP Address Dasar', 'type' => 'Video', 'duration' => '30 menit', 'icon' => '🌐', 'color' => '#F59E0B'],
            ['title' => 'OSI Model', 'type' => 'Video', 'duration' => '30 menit', 'icon' => '📚', 'color' => '#F97316'],
            ['title' => 'Subnetting Dasar', 'type' => 'Artikel', 'duration' => '20 menit', 'icon' => '🔧', 'color' => '#8B5CF6'],
        ];

        return view('dashboard.index', compact('user', 'progressData', 'recommendations'));
    }

    public function roadmap()
    {
        $user = Auth::user();
        $roadmaps = [
            [
                'title' => 'Jaringan Dasar TKJ',
                'progress' => 75,
                'total' => 8,
                'done' => 6,
                'status' => 'active',
                'color' => '#372466',
                'stages' => [
                    ['name' => 'Pengenalan Jaringan', 'done' => true],
                    ['name' => 'Model OSI', 'done' => true],
                    ['name' => 'IP Address & Subnetting', 'done' => true],
                    ['name' => 'Routing Dasar', 'done' => true],
                    ['name' => 'VLAN', 'done' => true],
                    ['name' => 'Wireless Networking', 'done' => true],
                    ['name' => 'Network Security', 'done' => false],
                    ['name' => 'Troubleshooting', 'done' => false],
                ]
            ],
            [
                'title' => 'Pemrograman Web Dasar',
                'progress' => 30,
                'total' => 10,
                'done' => 3,
                'status' => 'upcoming',
                'color' => '#F59E0B',
                'stages' => []
            ],
            [
                'title' => 'Administrasi Server Linux',
                'progress' => 0,
                'total' => 12,
                'done' => 0,
                'status' => 'locked',
                'color' => '#6B7280',
                'stages' => []
            ],
        ];
        return view('dashboard.roadmap', compact('user', 'roadmaps'));
    }

    public function target()
    {
        $user = Auth::user();
        $targets = [
            ['name' => 'Selesaikan Jaringan Dasar TKJ', 'deadline' => '30 Mei 2026', 'progress' => 75, 'status' => 'active'],
            ['name' => 'Belajar 5 materi per minggu', 'deadline' => 'Mingguan', 'progress' => 80, 'status' => 'active'],
            ['name' => 'Raih 10 Badge', 'deadline' => '30 Juni 2026', 'progress' => 120, 'status' => 'done'],
        ];
        return view('dashboard.target', compact('user', 'targets'));
    }

    public function progress()
    {
        $user = Auth::user();
        $stats = [
            'total_materi' => 64,
            'materi_selesai' => 10,
            'total_jam' => 48,
            'badges' => 12,
            'streak' => 7,
        ];
        $weekly = [
            ['week' => 'Minggu 1', 'val' => 60],
            ['week' => 'Minggu 2', 'val' => 50],
            ['week' => 'Minggu 3', 'val' => 80],
            ['week' => 'Minggu 4', 'val' => 90],
        ];
        return view('dashboard.progress', compact('user', 'stats', 'weekly'));
    }
}
