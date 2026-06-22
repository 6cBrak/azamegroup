<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'            => 'nullable|string|max:100',
            'site_logo'            => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'contact_email'        => 'nullable|email|max:150',
            'contact_phone'        => 'nullable|string|max:30',
            'contact_phone2'       => 'nullable|string|max:30',
            'contact_address'      => 'nullable|string|max:300',
            'contact_city'         => 'nullable|string|max:100',
            'contact_hours'        => 'nullable|string|max:200',
            'contact_map'          => 'nullable|string|max:1000',
            'whatsapp_number'      => 'nullable|string|max:30',
            'social_facebook'      => 'nullable|url|max:300',
            'social_instagram'     => 'nullable|url|max:300',
            'about_fr'             => 'nullable|string|max:5000',
            'about_en'             => 'nullable|string|max:5000',
            // Présentation
            'company_slogan'       => 'nullable|string|max:300',
            'company_slogan_en'    => 'nullable|string|max:300',
            'company_motto'        => 'nullable|string|max:200',
            'company_motto_en'     => 'nullable|string|max:200',
            'company_manager'      => 'nullable|string|max:100',
            'company_manager_title'=> 'nullable|string|max:100',
            'company_website'      => 'nullable|string|max:200',
            'company_intro'        => 'nullable|string|max:2000',
            'company_intro_en'     => 'nullable|string|max:2000',
            // Service 1
            'service1_title'       => 'nullable|string|max:200',
            'service1_title_en'    => 'nullable|string|max:200',
            'service1_subtitle'    => 'nullable|string|max:300',
            'service1_subtitle_en' => 'nullable|string|max:300',
            'service1_items'       => 'nullable|string|max:2000',
            'service1_items_en'    => 'nullable|string|max:2000',
            // Service 2
            'service2_title'       => 'nullable|string|max:200',
            'service2_title_en'    => 'nullable|string|max:200',
            'service2_subtitle'    => 'nullable|string|max:300',
            'service2_subtitle_en' => 'nullable|string|max:300',
            'service2_zones'       => 'nullable|string|max:200',
            'service2_items'       => 'nullable|string|max:2000',
            'service2_items_en'    => 'nullable|string|max:2000',
            // Valeurs
            'value1_title'         => 'nullable|string|max:100',
            'value1_title_en'      => 'nullable|string|max:100',
            'value1_text'          => 'nullable|string|max:300',
            'value1_text_en'       => 'nullable|string|max:300',
            'value2_title'         => 'nullable|string|max:100',
            'value2_title_en'      => 'nullable|string|max:100',
            'value2_text'          => 'nullable|string|max:300',
            'value2_text_en'       => 'nullable|string|max:300',
            'value3_title'         => 'nullable|string|max:100',
            'value3_title_en'      => 'nullable|string|max:100',
            'value3_text'          => 'nullable|string|max:300',
            'value3_text_en'       => 'nullable|string|max:300',
            'value4_title'         => 'nullable|string|max:100',
            'value4_title_en'      => 'nullable|string|max:100',
            'value4_text'          => 'nullable|string|max:300',
            'value4_text_en'       => 'nullable|string|max:300',
        ]);

        // Logo upload
        if ($request->boolean('remove_logo')) {
            $old = Setting::get('site_logo');
            if ($old) Storage::disk('public')->delete($old);
            Setting::set('site_logo', null);
        } elseif ($request->hasFile('site_logo')) {
            $old = Setting::get('site_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('site_logo')->store('logo', 'public');
            Setting::set('site_logo', $path);
        }

        $keys = [
            'site_name',
            'contact_email', 'contact_phone', 'contact_phone2',
            'contact_address', 'contact_city', 'contact_hours', 'contact_map',
            'whatsapp_number', 'social_facebook', 'social_instagram',
            'about_fr', 'about_en',
            // Présentation
            'company_slogan', 'company_slogan_en',
            'company_motto', 'company_motto_en',
            'company_manager', 'company_manager_title', 'company_website',
            'company_intro', 'company_intro_en',
            // Services
            'service1_title', 'service1_title_en', 'service1_subtitle', 'service1_subtitle_en', 'service1_items', 'service1_items_en',
            'service2_title', 'service2_title_en', 'service2_subtitle', 'service2_subtitle_en', 'service2_zones', 'service2_items', 'service2_items_en',
            // Valeurs
            'value1_title', 'value1_title_en', 'value1_text', 'value1_text_en',
            'value2_title', 'value2_title_en', 'value2_text', 'value2_text_en',
            'value3_title', 'value3_title_en', 'value3_text', 'value3_text_en',
            'value4_title', 'value4_title_en', 'value4_text', 'value4_text_en',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key));
        }

        return back()->with('success', 'Paramètres enregistrés avec succès.');
    }
}
