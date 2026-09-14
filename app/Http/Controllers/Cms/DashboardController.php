<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Candidate;
use App\Models\Vote;
use App\Services\IpaymuService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(IpaymuService $ipaymuService)
    {
        $ipaymuData = null;
        try {
            $ipaymuData = Cache::remember('ipaymu_cms_balance', 30, function () use ($ipaymuService) {
                return $ipaymuService->getBalance();
            });
        } catch (\Exception $e) {
            $ipaymuData = null;
        }

        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::where('status', 'active')->count(),
            'total_candidates' => Candidate::count(),
            'total_votes' => (int)Vote::where('payment_status', 'completed')->sum('quantity'),
            'total_tokens' => Token::count(),
            'used_tokens' => Token::where('is_used', true)->count(),
            'total_revenue' => (float)Vote::where('payment_status', 'completed')->sum('amount'),
            'ipaymu_balance' => $ipaymuData['merchant_balance'] ?? null,
            'ipaymu_va' => $ipaymuData['va'] ?? config('services.ipaymu.va', env('IPAYMU_VA', '')),
        ];

        // Recent events
        $recentEvents = Event::orderBy('created_at', 'desc')->take(5)->get();

        // Recent votes with event & candidate info
        $recentVotes = Vote::where('payment_status', 'completed')
            ->with(['event', 'candidate'])
            ->orderBy('voted_at', 'desc')
            ->take(5)
            ->get();

        // Get database info
        $dbConnection = config('database.default');
        $dbSize = 'Unknown';
        if ($dbConnection === 'sqlite') {
            $dbPath = config('database.connections.sqlite.database');
            if (file_exists($dbPath)) {
                $sizeBytes = filesize($dbPath);
                if ($sizeBytes >= 1048576) {
                    $dbSize = round($sizeBytes / 1048576, 2) . ' MB';
                } elseif ($sizeBytes >= 1024) {
                    $dbSize = round($sizeBytes / 1024, 2) . ' KB';
                } else {
                    $dbSize = $sizeBytes . ' bytes';
                }
            }
        } else {
            $dbName = config('database.connections.mysql.database');
            $dbSize = "MySQL: {$dbName}";
        }

        return view('cms.dashboard', compact('stats', 'recentEvents', 'recentVotes', 'dbSize'));
    }
}
