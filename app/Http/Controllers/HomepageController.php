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
     * Show the about us page
    */
    public function about()
    {
        return view('about-us');
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

    /**
     * Show the privacy page
    */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Show the FAQ page
    */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Show the Advice page
    */
    public function Advice()
    {
        return view('modelling-advice');
    }

    /**
     * Show the HowItWorks page
    */
    public function HowItWorks()
    {
        return view('how-it-works');
    }
}
