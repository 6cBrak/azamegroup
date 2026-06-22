<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function faq()
    {
        return view('legal.faq');
    }

    public function cgu()
    {
        return view('legal.cgu');
    }

    public function privacy()
    {
        return view('legal.privacy');
    }
}
