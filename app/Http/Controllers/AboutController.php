<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'about_fr'      => Setting::get('about_fr'),
            'about_en'      => Setting::get('about_en'),
            'contact_email' => Setting::get('contact_email'),
            'contact_phone' => Setting::get('contact_phone'),
            'contact_address'=> Setting::get('contact_address'),
            'contact_city'  => Setting::get('contact_city'),
            'contact_hours' => Setting::get('contact_hours'),
            'social_facebook'   => Setting::get('social_facebook'),
            'social_instagram'  => Setting::get('social_instagram'),
        ]);
    }
}
