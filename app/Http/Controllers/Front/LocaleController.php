<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch user interface locale between id and en
     */
    public function switch(Request $request, string $locale)
    {
        if (in_array($locale, ['id', 'en'], true)) {
            Session::put('locale', $locale);
            Cookie::queue(Cookie::make('locale', $locale, 60 * 24 * 365, '/'));
        }

        $prev = url()->previous();
        if (empty($prev) || str_contains($prev, '/lang/')) {
            return redirect()->route('home');
        }

        return redirect()->to($prev);
    }
}
