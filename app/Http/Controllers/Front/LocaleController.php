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

            if ($locale === 'en') {
                Cookie::queue(Cookie::make('googtrans', '/id/en', 60 * 24 * 365, '/'));
            } else {
                Cookie::queue(Cookie::make('googtrans', '/id/id', 60 * 24 * 365, '/'));
                Cookie::queue(Cookie::forget('googtrans'));
            }
        }

        $prev = url()->previous();
        if (empty($prev) || str_contains($prev, '/lang/')) {
            return redirect()->route('home');
        }

        return redirect()->to($prev);
    }
}
