<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $journalistProfile = $user->journalist;
        $articles = $journalistProfile ? $journalistProfile->articles : collect();

        return view('dashboard', compact('articles'));
    }
}
