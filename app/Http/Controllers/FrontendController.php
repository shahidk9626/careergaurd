<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function features()
    {
        return view('frontend.features');
    }

    public function howItWorks()
    {
        return view('frontend.how-it-works');
    }

    public function reviews()
    {
        return view('frontend.reviews');
    }

    public function subscribe()
    {
        return view('frontend.subscribe');
    }

    public function contactUs()
    {
        return view('frontend.contact-us');
    }

    public function download()
    {
        return view('frontend.download');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function refundPolicy()
    {
        return view('frontend.refund-policy');
    }

    public function terms()
    {
        return view('frontend.terms');
    }
}
