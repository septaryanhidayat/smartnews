<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'today_articles' => Article::whereDate('published_at', today())->count(),
            'month_articles' => Article::whereMonth('published_at', now()->month)->whereYear('published_at', now()->year)->count(),
            'total_views' => Article::sum('views_count'),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'total_users' => User::count(),
            'active_ads' => collect(['header', 'home_feed', 'sidebar', 'article_top', 'article_middle', 'article_bottom'])->filter(fn($slot) => function_exists('setting') && setting("ad_{$slot}_enabled", '0') == '1')->count(),
        ];

        // 1. Top 8 Most Popular Articles
        $topArticles = Article::with(['category', 'user'])
            ->orderBy('views_count', 'desc')
            ->take(8)
            ->get();

        // 2. Latest 8 Published Articles
        $latestArticles = Article::with(['category', 'user'])
            ->orderBy('published_at', 'desc')
            ->take(8)
            ->get();

        // 3. Category Distribution
        $categoryDistribution = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(7)
            ->get();

        // 4. Latest Comments
        $latestComments = Comment::with('article')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 5. System Error Logs (Parse last entries from laravel.log)
        $logs = $this->getRecentLogs();

        return view('admin.dashboard', compact(
            'stats',
            'topArticles',
            'latestArticles',
            'categoryDistribution',
            'latestComments',
            'logs'
        ));
    }

    public function syncDatabase()
    {
        $res = self::runDatabaseSync();
        if ($res['success']) {
            return redirect()->route('admin.dashboard')->with('success', $res['message']);
        }
        return redirect()->route('admin.dashboard')->with('error', $res['message']);
    }

    public static function runDatabaseSync()
    {
        $sqlPath = database_path('smartnews.sql');
        if (!File::exists($sqlPath)) {
            $sqlPath = base_path('smartnews.sql');
        }

        if (!File::exists($sqlPath)) {
            return ['success' => false, 'message' => 'File smartnews.sql tidak ditemukan di server.'];
        }

        $sql = File::get($sqlPath);
        $pattern = '/INSERT\s+INTO\s+`?([a-zA-Z0-9_]+)`?\s*(\([^\)]+\))?\s*VALUES\s*(.+?);(?=\s*(?:--|\/\*|INSERT|\Z))/is';
        preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER);

        if (!empty($matches)) {
            $isSqlite = \Illuminate\Support\Facades\DB::getDriverName() === 'sqlite';
            if ($isSqlite) {
                \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF;');
            } else {
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            }

            $tables = ['article_tag', 'articles', 'comments', 'tags', 'categories', 'site_settings', 'users'];
            foreach ($tables as $t) {
                if (\Illuminate\Support\Facades\Schema::hasTable($t)) {
                    \Illuminate\Support\Facades\DB::table($t)->delete();
                }
            }

            foreach ($matches as $match) {
                try {
                    \Illuminate\Support\Facades\DB::unprepared($match[0]);
                } catch (\Exception $e) {
                    // continue
                }
            }

            // Ensure admin accounts and standard passwords
            \Illuminate\Support\Facades\DB::table('users')->where('id', 1)->update([
                'name' => 'Budi Santoso',
                'email' => 'info@berandadigital.net',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password')
            ]);
            \Illuminate\Support\Facades\DB::table('users')->where('id', 3)->update([
                'name' => 'Super Administrator',
                'email' => 'admin@smartnews.id',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password')
            ]);
            \Illuminate\Support\Facades\DB::table('users')->where('id', 2)->update([
                'name' => 'Siti Nurhaliza',
                'email' => 'redaksi@smartnews.id',
                'role' => 'editor',
                'password' => \Illuminate\Support\Facades\Hash::make('password')
            ]);
            \Illuminate\Support\Facades\DB::table('users')->where('id', 4)->update([
                'name' => 'Ahmad Fauzi (Wartawan)',
                'email' => 'wartawan@smartnews.id',
                'role' => 'author',
                'password' => \Illuminate\Support\Facades\Hash::make('password')
            ]);

            if ($isSqlite) {
                \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON;');
            } else {
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            return [
                'success' => true,
                'message' => 'Database berhasil disinkronkan! Total ' . Article::count() . ' artikel berita, ' . Category::count() . ' kategori, dan ' . Tag::count() . ' tags aktif.'
            ];
        }

        return ['success' => false, 'message' => 'Gagal memproses query SQL.'];
    }

    public function clearLogs()
    {
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Log error sistem berhasil dibersihkan!');
    }

    private function getRecentLogs($maxEntries = 20)
    {
        $logPath = storage_path('logs/laravel.log');
        if (!File::exists($logPath) || File::size($logPath) === 0) {
            return [];
        }

        $fileContent = File::get($logPath);
        if (empty(trim($fileContent))) {
            return [];
        }

        // Split log entries by timestamp pattern [YYYY-MM-DD HH:MM:SS]
        $rawEntries = preg_split('/(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/', $fileContent, -1, PREG_SPLIT_NO_EMPTY);
        $rawEntries = array_reverse($rawEntries); // Newest first

        $parsedLogs = [];
        $count = 0;

        foreach ($rawEntries as $entry) {
            if ($count >= $maxEntries) break;

            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]\s+([\w\.]+): (.*)/s', trim($entry), $matches)) {
                $time = $matches[1];
                $envLevel = $matches[2];
                $messageFull = $matches[3];

                // Determine level
                $level = 'INFO';
                if (stripos($envLevel, 'error') !== false || stripos($envLevel, 'critical') !== false || stripos($envLevel, 'emergency') !== false) {
                    $level = 'ERROR';
                } elseif (stripos($envLevel, 'warning') !== false) {
                    $level = 'WARNING';
                } elseif (stripos($envLevel, 'debug') !== false) {
                    $level = 'DEBUG';
                }

                $lines = explode("\n", $messageFull);
                $firstLine = trim($lines[0] ?? '');
                $trace = count($lines) > 1 ? implode("\n", array_slice($lines, 1, 15)) : null;

                $parsedLogs[] = [
                    'timestamp' => $time,
                    'level' => $level,
                    'env' => $envLevel,
                    'message' => $firstLine,
                    'trace' => $trace,
                ];

                $count++;
            }
        }

        return $parsedLogs;
    }
}
