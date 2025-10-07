<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function dmca(): View
    {
        return view('pages.dmca');
    }

    public function disclaimer(): View
    {
        return view('pages.disclaimer');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
}
