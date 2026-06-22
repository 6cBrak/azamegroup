<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(string $locale)
    {
        if (in_array($locale, ['fr', 'en'])) {
            session(['locale' => $locale]);
        }
        return back();
    }
}
