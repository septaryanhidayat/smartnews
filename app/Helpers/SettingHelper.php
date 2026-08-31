<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('site_logo')) {
    function site_logo()
    {
        $logo = setting('site_logo');
        if ($logo) {
            if (file_exists(public_path('uploads/settings/' . $logo))) {
                return asset('uploads/settings/' . $logo);
            }
            if (file_exists(public_path('storage/' . $logo))) {
                return asset('storage/' . $logo);
            }
            if (file_exists(public_path($logo))) {
                return asset($logo);
            }
        }
        return asset('images/logo.svg');
    }
}

if (!function_exists('site_logo_dark')) {
    function site_logo_dark()
    {
        $logo = setting('site_logo_dark');
        if ($logo) {
            if (file_exists(public_path('uploads/settings/' . $logo))) {
                return asset('uploads/settings/' . $logo);
            }
            if (file_exists(public_path('storage/' . $logo))) {
                return asset('storage/' . $logo);
            }
            if (file_exists(public_path($logo))) {
                return asset($logo);
            }
        }
        return asset('images/logo-white.svg');
    }
}

if (!function_exists('site_favicon')) {
    function site_favicon()
    {
        $favicon = setting('site_favicon');
        if ($favicon) {
            if (file_exists(public_path('uploads/settings/' . $favicon))) {
                return asset('uploads/settings/' . $favicon);
            }
            if (file_exists(public_path('storage/' . $favicon))) {
                return asset('storage/' . $favicon);
            }
            if (file_exists(public_path($favicon))) {
                return asset($favicon);
            }
        }
        return asset('images/logo.svg');
    }
}

if (!function_exists('ad_is_active')) {
    function ad_is_active($slot)
    {
        $enabled = setting("ad_{$slot}_enabled", '0');
        if ($enabled !== '1') {
            return false;
        }

        $type = setting("ad_{$slot}_type", 'image');
        if ($type === 'image') {
            $image = setting("ad_{$slot}_image");
            return !empty($image) && file_exists(public_path('uploads/ads/' . $image));
        }

        if ($type === 'code') {
            $code = setting("ad_{$slot}_code");
            return !empty(trim($code));
        }

        return false;
    }
}

if (!function_exists('ad_render')) {
    function ad_render($slot, $extraClasses = '')
    {
        if (!ad_is_active($slot)) {
            return '';
        }

        $type = setting("ad_{$slot}_type", 'image');
        $html = '<div class="ad-placement-slot ad-slot--' . e($slot) . ' ' . e($extraClasses) . '">';
        $html .= '<span class="ad-label">IKLAN / SPONSORED</span>';

        if ($type === 'image') {
            $image = setting("ad_{$slot}_image");
            $url = setting("ad_{$slot}_url", '#');
            $target = setting("ad_{$slot}_target", '_blank');
            $imgSrc = asset('uploads/ads/' . $image);

            $html .= '<div class="ad-banner-wrap">';
            if (!empty($url) && $url !== '#') {
                $html .= '<a href="' . e($url) . '" target="' . e($target) . '" rel="nofollow sponsored noopener">';
                $html .= '<img src="' . $imgSrc . '" alt="Sponsor Ad" class="ad-banner-img" loading="lazy">';
                $html .= '</a>';
            } else {
                $html .= '<img src="' . $imgSrc . '" alt="Sponsor Ad" class="ad-banner-img" loading="lazy">';
            }
            $html .= '</div>';
        } elseif ($type === 'code') {
            $code = setting("ad_{$slot}_code");
            $html .= '<div class="ad-code-wrap">' . $code . '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('inject_in_content_ad')) {
    function inject_in_content_ad($content, $slot = 'article_middle')
    {
        if (!ad_is_active($slot)) {
            return $content;
        }

        $adHtml = ad_render($slot, 'ad-slot--in-content');
        if (empty($adHtml)) {
            return $content;
        }

        // Insert after 2nd </p> tag, or fallback to 1st </p>
        $closingTag = '</p>';
        $pCount = substr_count(strtolower($content), $closingTag);

        if ($pCount >= 3) {
            $pos = 0;
            // Find 2nd occurrence of </p>
            for ($i = 0; $i < 2; $i++) {
                $pos = stripos($content, $closingTag, $pos);
                if ($pos !== false) {
                    $pos += strlen($closingTag);
                } else {
                    break;
                }
            }
            if ($pos !== false) {
                return substr_replace($content, "\n" . $adHtml . "\n", $pos, 0);
            }
        } elseif ($pCount >= 1) {
            $pos = stripos($content, $closingTag);
            if ($pos !== false) {
                $pos += strlen($closingTag);
                return substr_replace($content, "\n" . $adHtml . "\n", $pos, 0);
            }
        }

        return $content . "\n" . $adHtml;
    }
}
