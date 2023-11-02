<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Show the profile for a given parento.
     */
    public function parento()
    {
        return view('about.parento');
    }
}
