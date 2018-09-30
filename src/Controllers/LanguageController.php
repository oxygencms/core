<?php

namespace Oxygencms\Core\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        $languages = config('app.locales');

        if (!array_key_exists($locale, $languages)) {
            redirect()->back();
        }

        session()->put('app_locale', $locale);

        return redirect()->back();
    }
}
