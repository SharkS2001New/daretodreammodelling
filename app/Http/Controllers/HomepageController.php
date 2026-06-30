<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Photo;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    public function index()
    {
        // Cache testimonials forever
        $testimonials = Cache::rememberForever("homepage_testimonials", function () {
            return Testimonial::latest()->paginate(10);
        });

        // Get latest photo per user, ordered by total likes
        $photoIds = Photo::selectRaw('MAX(id) as id')
            ->groupBy('user_id')
            ->pluck('id');

        $photos = Photo::whereIn('id', $photoIds)
            ->with(['user.publicInfo'])
            ->orderByUserLikes()
            ->take(8)
            ->get();

        return view('homepage', compact('testimonials', 'photos'));
    }
    
    /**
     * Show the about us page
    */
    public function about()
    {
        return view('about-us');
    }

    public function upcomingActivities()
    {
        return view('upcoming-activities');
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

    /**
     * Show the HowItWorks page
    */
    public function Account()
    {
        return view('account');
    }
}
