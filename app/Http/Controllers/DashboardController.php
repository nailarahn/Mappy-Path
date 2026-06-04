<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roadmap;
use App\Models\UserRoadmap;
use App\Models\UserStage;
use App\Models\LearningLog;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Enrollment aktif user
        $activeEnrollment = UserRoadmap::with('roadmap')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        // Roadmap yang sudah diambil user
        $enrolledIds = UserRoadmap::where('user_id', $user->id)
            ->pluck('roadmap_id');

        // Recommendation roadmap
        $recommendations = Roadmap::where('is_active', true)
            ->whereNotIn('id', $enrolledIds)
            ->limit(3)
            ->get()
            ->map(function ($r) {
                return [
                    'title'    => $r->title,
                    'type'     => 'Video',
                    'duration' => $r->estimated_hours . ' jam',
                    'icon'     => '🌐',
                    'color'    => '#372466',
                ];
            });

        // Total menit belajar minggu ini
        $weeklyMinutes = LearningLog::where('user_id', $user->id)
            ->whereBetween('log_date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])
            ->sum('duration_minutes');

        // Progress mingguan
        $progressData = [];

        for ($i = 3; $i >= 0; $i--) {

            $start = now()->subWeeks($i)->startOfWeek()->toDateString();
            $end   = now()->subWeeks($i)->endOfWeek()->toDateString();

            $mins = LearningLog::where('user_id', $user->id)
                ->whereBetween('log_date', [$start, $end])
                ->sum('duration_minutes');

            $progressData[] = [
                'minggu'   => 'Minggu ' . (4 - $i),
                'progress' => $mins > 0 ? min(100, (int) ($mins / 6)) : 0,
            ];
        }

        return view('dashboard.index', compact(
            'user',
            'progressData',
            'recommendations',
            'activeEnrollment',
            'weeklyMinutes'
        ));
    }

    public function roadmap()
    {
        $user = Auth::user();

        $completedStageIds = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('stage_id')
            ->toArray();

        $enrolledRoadmapIds = UserRoadmap::where('user_id', $user->id)
            ->pluck('roadmap_id')
            ->toArray();

        $roadmaps = Roadmap::with([
                'stages' => function ($q) {
                    $q->where('is_active', true)
                      ->orderBy('order');
                }
            ])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($r) use ($enrolledRoadmapIds, $user) {

                $enrollment = UserRoadmap::where('user_id', $user->id)
                    ->where('roadmap_id', $r->id)
                    ->first();

                $r->is_enrolled = in_array($r->id, $enrolledRoadmapIds);

                $r->user_progress = $enrollment?->progress ?? 0;

                return $r;
            });

        return view('dashboard.roadmap', compact(
            'roadmaps',
            'completedStageIds'
        ));
    }

    public function stage($roadmapId, $stageId)
    {
        $user = Auth::user();

        $roadmap = Roadmap::with([
                'stages' => function ($q) {
                    $q->where('is_active', true)
                      ->orderBy('order');
                }
            ])
            ->findOrFail($roadmapId);

        $stage = $roadmap->stages->firstWhere('id', $stageId);

        if (!$stage) {
            abort(404);
        }

        // Cek enrollment
        $enrollment = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if (!$enrollment) {
            return redirect()
                ->route('roadmap')
                ->with('error', 'Kamu belum terdaftar di roadmap ini.');
        }

        $completedStageIds = UserStage::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->where('is_completed', true)
            ->pluck('stage_id')
            ->toArray();

        $isCompleted = in_array($stageId, $completedStageIds);

        $doneCount = count($completedStageIds);

        $progressPercent = $roadmap->total_stages > 0
            ? min(100, (int) round(($doneCount / $roadmap->total_stages) * 100))
            : 0;

        $allStages = $roadmap->stages;

        $currentGroupIndex = 0;

        $groupedStages = $allStages->groupBy(function ($s) {
            return $s->group_label ?: $s->title;
        });

        foreach ($groupedStages as $idx => $grp) {
            if ($grp->contains('id', (int) $stageId)) {
                $currentGroupIndex = $idx;
                break;
            }
        }

        return view('dashboard.stage', compact(
            'roadmap',
            'stage',
            'allStages',
            'completedStageIds',
            'isCompleted',
            'doneCount',
            'progressPercent',
            'currentGroupIndex'
        ));
    }

    public function enroll($roadmapId)
    {
        $user = Auth::user();

        $roadmap = Roadmap::findOrFail($roadmapId);

        $existing = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if (!$existing) {

            UserRoadmap::create([
                'user_id'    => $user->id,
                'roadmap_id' => $roadmapId,
                'progress'   => 0,
                'status'     => 'active',
                'started_at' => now(),
            ]);
        }

        $firstStage = $roadmap->stages()
            ->orderBy('order')
            ->first();

        if ($firstStage) {

            return redirect()->route('roadmap.stage', [
                'roadmapId' => $roadmapId,
                'stageId'   => $firstStage->id,
            ])->with('success', 'Berhasil mendaftar! Selamat belajar 🎉');
        }

        return redirect()
            ->route('roadmap')
            ->with('success', 'Berhasil mendaftar ke roadmap!');
    }

    public function completeStage(Request $request, $roadmapId, $stageId)
    {
        $user = Auth::user();

        $enrollment = UserRoadmap::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->firstOrFail();

        // Tandai stage selesai
        UserStage::updateOrCreate(
            [
                'user_id'  => $user->id,
                'stage_id' => $stageId
            ],
            [
                'roadmap_id'         => $roadmapId,
                'is_completed'       => true,
                'completed_at'       => now(),
                'time_spent_minutes' => $request->input('time_spent_minutes', 30),
            ]
        );

        // Update progress
        $totalStages = Roadmap::find($roadmapId)?->total_stages ?? 1;

        $completedStages = UserStage::where('user_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->where('is_completed', true)
            ->count();

        $progress = $totalStages > 0
            ? min(100, (int) round(($completedStages / $totalStages) * 100))
            : 0;

        $enrollment->update([
            'progress'     => $progress,
            'status'       => $progress >= 100 ? 'completed' : 'active',
            'completed_at' => $progress >= 100 ? now() : null,
        ]);

        // Learning log
        LearningLog::create([
            'user_id'          => $user->id,
            'stage_id'         => $stageId,
            'roadmap_id'       => $roadmapId,
            'duration_minutes' => $request->input('time_spent_minutes', 30),
            'log_date'         => now()->toDateString(),
            'activity'         => 'study',
        ]);

        // Cari next stage
        $roadmap = Roadmap::with([
                'stages' => fn($q) => $q->orderBy('order')
            ])
            ->find($roadmapId);

        $stageIds = $roadmap->stages
            ->pluck('id')
            ->toArray();

        $currentIdx = array_search((int) $stageId, $stageIds);

        $nextStage = $stageIds[$currentIdx + 1] ?? null;

        if ($nextStage) {

            return redirect()->route('roadmap.stage', [
                'roadmapId' => $roadmapId,
                'stageId'   => $nextStage,
            ])->with('success', 'Tahap selesai! Lanjut ke materi berikutnya 🎉');
        }

        return redirect()
            ->route('roadmap')
            ->with('success', 'Selamat! Kamu telah menyelesaikan semua materi di roadmap ini 🏆');
    }

    
    // TARGET
    public function target()
    {
        $user = Auth::user();

        $targets = $user->targets()
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.target', compact(
            'user',
            'targets'
        ));
    }

    public function targetCreate()
    {
        return view('dashboard.targetform');
    }

    public function targetStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'target_value' => 'required|integer|min:1',
            'start_date'   => 'nullable|date',
            'deadline'     => 'nullable|date',
        ]);

        Auth::user()->targets()->create([
            'name'          => $request->name,
            'description'   => $request->description,
            'target_value'  => $request->target_value,
            'current_value' => 0,
            'start_date'    => $request->start_date,
            'deadline'      => $request->deadline,
            'status'        => 'active',
        ]);

        return redirect()
            ->route('target')
            ->with('success', 'Target berhasil ditambahkan! 🎯');
    }

    public function targetEdit($id)
    {
        $target = Auth::user()->targets()->findOrFail($id);

        return view('dashboard.targetform', compact('target'));
    }

    public function targetUpdate(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'target_value' => 'required|integer|min:1',
            'start_date'   => 'nullable|date',
            'deadline'     => 'nullable|date',
        ]);

        $target = Auth::user()->targets()->findOrFail($id);

        $target->update([
            'name'         => $request->name,
            'description'  => $request->description,
            'target_value' => $request->target_value,
            'start_date'   => $request->start_date,
            'deadline'     => $request->deadline,
        ]);

        return redirect()
            ->route('target')
            ->with('success', 'Target berhasil diperbarui! ✅');
    }

    public function targetDestroy($id)
    {
        Auth::user()
            ->targets()
            ->findOrFail($id)
            ->delete();

        return redirect()
            ->route('target')
            ->with('success', 'Target berhasil dihapus! 🗑️');
    }

    public function progress()
    {
        $user = Auth::user();

        $totalHariBelajar = LearningLog::where('user_id', $user->id)
            ->selectRaw('COUNT(DISTINCT DATE(log_date)) as total')
            ->value('total') ?? 0;

        $materiSelesai = UserStage::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $totalJam = round(LearningLog::where('user_id', $user->id)->sum('duration_minutes') / 60);

        $badgeEarned = \DB::table('user_badges')->where('user_id', $user->id)->count();

        $chartData = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek()->toDateString();
            $end   = now()->subWeeks($i)->endOfWeek()->toDateString();

            $mins = LearningLog::where('user_id', $user->id)
                ->whereBetween('log_date', [$start, $end])
                ->sum('duration_minutes');

            $chartData[] = [
                'label'  => $i === 0 ? 'Minggu ini' : 'Minggu -' . $i,
                'materi' => UserStage::where('user_id', $user->id)
                    ->where('is_completed', true)
                    ->whereBetween('completed_at', [$start, $end])
                    ->count(),
                'jam' => round($mins / 60),
            ];
        }

        $unlockedIds = \DB::table('user_badges')->where('user_id', $user->id)->pluck('badge_id')->toArray();
        $badges = \DB::table('badges')->get()->map(fn($b) => [
            'name'     => $b->name,
            'desc'     => $b->description,
            'color'    => $b->color ?? 'indigo',
            'unlocked' => in_array($b->id, $unlockedIds),
        ])->toArray();

        return view('dashboard.progress', compact(
            'totalHariBelajar',
            'materiSelesai',
            'totalJam',
            'badgeEarned',
            'chartData',
            'badges'
        ));
    }
}