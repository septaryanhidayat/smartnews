<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TranslationService
{
    /**
     * Translate plain text from source to target language with caching
     */
    public static function translateText(string $text, string $target = 'en', string $source = 'id'): string
    {
        $text = trim($text);
        if (empty($text) || $target === $source) {
            return $text;
        }

        $cacheKey = 'trans_' . $source . '_' . $target . '_' . md5($text);

        return Cache::rememberForever($cacheKey, function () use ($text, $target, $source) {
            try {
                $response = Http::timeout(4)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    ])
                    ->get('https://translate.googleapis.com/translate_a/single', [
                        'client' => 'gtx',
                        'sl' => $source,
                        'tl' => $target,
                        'dt' => 't',
                        'q' => $text,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                        $result = '';
                        foreach ($data[0] as $part) {
                            if (isset($part[0])) {
                                $result .= $part[0];
                            }
                        }
                        if (!empty(trim($result))) {
                            return $result;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Fallback to original text if offline or timeout
            }

            return $text;
        });
    }

    /**
     * Translate HTML content while preserving tags
     */
    public static function translateHtml(string $html, string $target = 'en', string $source = 'id'): string
    {
        if (empty(trim($html)) || $target === $source) {
            return $html;
        }

        $cacheKey = 'trans_html_' . $source . '_' . $target . '_' . md5($html);

        return Cache::rememberForever($cacheKey, function () use ($html, $target, $source) {
            // Translate paragraph by paragraph for better accuracy
            $pattern = '/(<(?:p|h1|h2|h3|h4|h5|h6|li|blockquote)[^>]*>)(.*?)(<\/(?:p|h1|h2|h3|h4|h5|h6|li|blockquote)>)/is';
            
            $translated = preg_replace_callback($pattern, function ($matches) use ($target, $source) {
                $tagOpen = $matches[1];
                $inner = $matches[2];
                $tagClose = $matches[3];

                $cleanInner = strip_tags($inner);
                if (mb_strlen(trim($cleanInner)) > 2) {
                    $translatedText = self::translateText($cleanInner, $target, $source);
                    return $tagOpen . $translatedText . $tagClose;
                }
                return $matches[0];
            }, $html);

            return $translated ?: $html;
        });
    }
}
