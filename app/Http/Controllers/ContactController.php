<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact', [
            'contact_email'  => Setting::get('contact_email'),
            'contact_phone'  => Setting::get('contact_phone'),
            'contact_address'=> Setting::get('contact_address'),
            'contact_city'   => Setting::get('contact_city'),
            'contact_hours'  => Setting::get('contact_hours'),
            'contact_map'    => Setting::get('contact_map'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:150',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->only('name', 'email', 'phone', 'subject', 'message'));

        return back()->with('success', __('contact.success'));
    }
}
