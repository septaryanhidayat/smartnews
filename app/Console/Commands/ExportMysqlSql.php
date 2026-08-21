<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportMysqlSql extends Command
{
    protected $signature = 'smartnews:export-mysql';
    protected $description = 'Export all tables and data as a clean MySQL / cPanel dump SQL file';

    public function handle()
    {
        $this->info('Generating MySQL database dump for cPanel phpMyAdmin...');

        $sql = "-- ========================================================\n";
        $sql .= "-- SmartNews Portal - MySQL Database Dump for cPanel\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Target Engine: MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.3+\n";
        $sql .= "-- ========================================================\n\n";

        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sql .= "START TRANSACTION;\n";
        $sql .= "SET time_zone = \"+07:00\";\n\n";

        // 1. USERS TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `users`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `users`;\n";
        $sql .= "CREATE TABLE `users` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `email_verified_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  UNIQUE KEY `users_email_unique` (`email`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $users = DB::table('users')->get();
        if ($users->count() > 0) {
            $sql .= "INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES\n";
            $uRows = [];
            foreach ($users as $u) {
                $pwd = $u->password;
                $uRows[] = sprintf(
                    "(%d, %s, %s, %s, %s, %s, %s, %s)",
                    $u->id,
                    $this->quote($u->name),
                    $this->quote($u->email),
                    $this->quote($u->email_verified_at),
                    $this->quote($pwd),
                    $this->quote($u->remember_token),
                    $this->quote($u->created_at),
                    $this->quote($u->updated_at)
                );
            }
            $sql .= implode(",\n", $uRows) . ";\n\n";
        }

        // 2. CATEGORIES TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `categories`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `categories`;\n";
        $sql .= "CREATE TABLE `categories` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#1a56db',\n";
        $sql .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  UNIQUE KEY `categories_slug_unique` (`slug`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $categories = DB::table('categories')->get();
        if ($categories->count() > 0) {
            $sql .= "INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `order`, `created_at`, `updated_at`) VALUES\n";
            $cRows = [];
            foreach ($categories as $c) {
                $cRows[] = sprintf(
                    "(%d, %s, %s, %s, %s, %d, %s, %s)",
                    $c->id,
                    $this->quote($c->name),
                    $this->quote($c->slug),
                    $this->quote($c->description),
                    $this->quote($c->color),
                    $c->order ?? 0,
                    $this->quote($c->created_at),
                    $this->quote($c->updated_at)
                );
            }
            $sql .= implode(",\n", $cRows) . ";\n\n";
        }

        // 3. TAGS TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `tags`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `tags`;\n";
        $sql .= "CREATE TABLE `tags` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  UNIQUE KEY `tags_slug_unique` (`slug`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $tags = DB::table('tags')->get();
        if ($tags->count() > 0) {
            $sql .= "INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES\n";
            $tRows = [];
            foreach ($tags as $t) {
                $tRows[] = sprintf(
                    "(%d, %s, %s, %s, %s)",
                    $t->id,
                    $this->quote($t->name),
                    $this->quote($t->slug),
                    $this->quote($t->created_at),
                    $this->quote($t->updated_at)
                );
            }
            $sql .= implode(",\n", $tRows) . ";\n\n";
        }

        // 4. ARTICLES TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `articles`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `articles`;\n";
        $sql .= "CREATE TABLE `articles` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `user_id` bigint(20) UNSIGNED NOT NULL,\n";
        $sql .= "  `category_id` bigint(20) UNSIGNED NOT NULL,\n";
        $sql .= "  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `image_caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `image_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `media_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',\n";
        $sql .= "  `media_badge` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `video_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `is_sticky` tinyint(1) NOT NULL DEFAULT 0,\n";
        $sql .= "  `is_slider` tinyint(1) NOT NULL DEFAULT 0,\n";
        $sql .= "  `views_count` int(11) NOT NULL DEFAULT 0,\n";
        $sql .= "  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',\n";
        $sql .= "  `published_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  UNIQUE KEY `articles_slug_unique` (`slug`),\n";
        $sql .= "  KEY `articles_user_id_foreign` (`user_id`),\n";
        $sql .= "  KEY `articles_category_id_foreign` (`category_id`),\n";
        $sql .= "  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,\n";
        $sql .= "  CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $articles = DB::table('articles')->get();
        if ($articles->count() > 0) {
            $sql .= "INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `image`, `image_caption`, `image_source`, `media_type`, `media_badge`, `video_url`, `video_id`, `is_sticky`, `is_slider`, `views_count`, `status`, `published_at`, `created_at`, `updated_at`) VALUES\n";
            $aRows = [];
            foreach ($articles as $a) {
                $aRows[] = sprintf(
                    "(%d, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d, %s, %s, %s, %s)",
                    $a->id,
                    $a->user_id,
                    $a->category_id,
                    $this->quote($a->title),
                    $this->quote($a->slug),
                    $this->quote($a->excerpt),
                    $this->quote($a->content),
                    $this->quote($a->image),
                    $this->quote($a->image_caption),
                    $this->quote($a->image_source),
                    $this->quote($a->media_type),
                    $this->quote($a->media_badge),
                    $this->quote($a->video_url),
                    $this->quote($a->video_id),
                    $a->is_sticky ? 1 : 0,
                    $a->is_slider ? 1 : 0,
                    $a->views_count ?? 0,
                    $this->quote($a->status),
                    $this->quote($a->published_at),
                    $this->quote($a->created_at),
                    $this->quote($a->updated_at)
                );
            }
            $sql .= implode(",\n", $aRows) . ";\n\n";
        }

        // 5. ARTICLE_TAG TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `article_tag`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `article_tag`;\n";
        $sql .= "CREATE TABLE `article_tag` (\n";
        $sql .= "  `article_id` bigint(20) UNSIGNED NOT NULL,\n";
        $sql .= "  `tag_id` bigint(20) UNSIGNED NOT NULL,\n";
        $sql .= "  PRIMARY KEY (`article_id`,`tag_id`),\n";
        $sql .= "  KEY `article_tag_tag_id_foreign` (`tag_id`),\n";
        $sql .= "  CONSTRAINT `article_tag_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,\n";
        $sql .= "  CONSTRAINT `article_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $articleTags = DB::table('article_tag')->get();
        if ($articleTags->count() > 0) {
            $sql .= "INSERT INTO `article_tag` (`article_id`, `tag_id`) VALUES\n";
            $atRows = [];
            foreach ($articleTags as $at) {
                $atRows[] = sprintf("(%d, %d)", $at->article_id, $at->tag_id);
            }
            $sql .= implode(",\n", $atRows) . ";\n\n";
        }

        // 6. COMMENTS TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `comments`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `comments`;\n";
        $sql .= "CREATE TABLE `comments` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `article_id` bigint(20) UNSIGNED NOT NULL,\n";
        $sql .= "  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `is_approved` tinyint(1) NOT NULL DEFAULT 1,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  KEY `comments_article_id_foreign` (`article_id`),\n";
        $sql .= "  CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $comments = DB::table('comments')->get();
        if ($comments->count() > 0) {
            $sql .= "INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES\n";
            $comRows = [];
            foreach ($comments as $com) {
                $comRows[] = sprintf(
                    "(%d, %d, %s, %s, %s, %d, %s, %s)",
                    $com->id,
                    $com->article_id,
                    $this->quote($com->name),
                    $this->quote($com->email),
                    $this->quote($com->comment),
                    $com->is_approved ? 1 : 0,
                    $this->quote($com->created_at),
                    $this->quote($com->updated_at)
                );
            }
            $sql .= implode(",\n", $comRows) . ";\n\n";
        }

        // 7. SITE_SETTINGS TABLE
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `site_settings`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `site_settings`;\n";
        $sql .= "CREATE TABLE `site_settings` (\n";
        $sql .= "  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        $sql .= "  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  UNIQUE KEY `site_settings_key_unique` (`key`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $settings = DB::table('site_settings')->get();
        if ($settings->count() > 0) {
            $sql .= "INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES\n";
            $setRows = [];
            foreach ($settings as $s) {
                $setRows[] = sprintf(
                    "(%d, %s, %s, %s, %s)",
                    $s->id,
                    $this->quote($s->key),
                    $this->quote($s->value),
                    $this->quote($s->created_at),
                    $this->quote($s->updated_at)
                );
            }
            $sql .= implode(",\n", $setRows) . ";\n\n";
        }

        // 8. LARAVEL UTILITY TABLES (Sessions, Cache, Jobs)
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `sessions`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `sessions`;\n";
        $sql .= "CREATE TABLE `sessions` (\n";
        $sql .= "  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `user_id` bigint(20) UNSIGNED DEFAULT NULL,\n";
        $sql .= "  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n";
        $sql .= "  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `last_activity` int(11) NOT NULL,\n";
        $sql .= "  PRIMARY KEY (`id`),\n";
        $sql .= "  KEY `sessions_user_id_index` (`user_id`),\n";
        $sql .= "  KEY `sessions_last_activity_index` (`last_activity`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "-- Struktur tabel: `cache`\n";
        $sql .= "-- --------------------------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `cache`;\n";
        $sql .= "CREATE TABLE `cache` (\n";
        $sql .= "  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,\n";
        $sql .= "  `expiration` int(11) NOT NULL,\n";
        $sql .= "  PRIMARY KEY (`key`)\n";
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sql .= "COMMIT;\n";

        // Write SQL dump files
        $target1 = database_path('smartnews.sql');
        $target2 = base_path('smartnews.sql');

        File::put($target1, $sql);
        File::put($target2, $sql);

        $this->info("Exported successfully to: database/smartnews.sql (" . round(strlen($sql) / 1024) . " KB)");
        $this->info("Also copied to root: smartnews.sql");
        return 0;
    }

    private function quote($val)
    {
        if ($val === null) {
            return "NULL";
        }
        return "'" . addslashes((string)$val) . "'";
    }
}
