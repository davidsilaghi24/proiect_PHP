<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Aici poți adăuga logica pentru a trimite date la view, dacă este necesar
        return view('dashboard');
    }
}
