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
