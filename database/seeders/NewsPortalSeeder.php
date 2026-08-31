<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class NewsPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('smartnews.sql');
        
        if (File::exists($sqlPath)) {
            $sql = File::get($sqlPath);
            
            // Execute all INSERT INTO blocks from smartnews.sql
            $pattern = '/INSERT\s+INTO\s+`?([a-zA-Z0-9_]+)`?\s*(\([^\)]+\))?\s*VALUES\s*(.+?);(?=\s*(?:--|\/\*|INSERT|\Z))/is';
            preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER);
            
            if (!empty($matches)) {
                $isSqlite = DB::getDriverName() === 'sqlite';
                if ($isSqlite) {
                    DB::statement('PRAGMA foreign_keys = OFF;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                }

                $tables = ['article_tag', 'articles', 'comments', 'tags', 'categories', 'site_settings'];
                foreach ($tables as $t) {
                    if (Schema::hasTable($t)) {
                        DB::table($t)->delete();
                    }
                }

                foreach ($matches as $match) {
                    try {
                        DB::unprepared($match[0]);
                    } catch (\Exception $e) {
                        // ignore or log
                    }
                }

                // Ensure admin accounts and standard passwords
                User::updateOrCreate(
                    ['email' => 'admin@smartnews.id'],
                    [
                        'name' => 'Super Administrator',
                        'role' => 'admin',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );
                User::updateOrCreate(
                    ['email' => 'info@berandadigital.net'],
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'admin',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );
                User::updateOrCreate(
                    ['email' => 'redaksi@smartnews.id'],
                    [
                        'name' => 'Siti Nurhaliza',
                        'role' => 'editor',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );
                User::updateOrCreate(
                    ['email' => 'wartawan@smartnews.id'],
                    [
                        'name' => 'Ahmad Fauzi (Wartawan)',
                        'role' => 'author',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );

                if ($isSqlite) {
                    DB::statement('PRAGMA foreign_keys = ON;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                }

                if ($this->command) {
                    $this->command->info("NewsPortalSeeder successfully seeded " . Article::count() . " articles, " . Category::count() . " categories, and " . Tag::count() . " tags from smartnews.sql!");
                }
                return;
            }
        }
    }
}
