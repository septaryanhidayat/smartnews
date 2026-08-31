<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        }

        return redirect()->back();
    }
}
