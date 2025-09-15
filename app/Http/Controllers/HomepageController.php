<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage');
    } 

    /**
     * Show the contact page
    */
    public function contact()
    {
        return view('contact-us');
    }

    /**
     * Show the FAQ page
    */
    public function faq()
    {
        return view('faq');
    }
}
