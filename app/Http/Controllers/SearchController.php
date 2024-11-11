<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('front.site.search'); // فایل view مربوط به صفحه جستجو
    }
}
