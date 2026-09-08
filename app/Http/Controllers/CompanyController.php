<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Team;

class CompanyController extends Controller
{
    public function about()
    {
        $about = About::first();

        return view('company.about', compact('about'));
    }

    public function team()
    {
        $about = About::first();
        $teams = Team::where('is_active', true)->orderBy('sort_order')->get();

        return view('company.team', compact('about', 'teams'));
    }
}
