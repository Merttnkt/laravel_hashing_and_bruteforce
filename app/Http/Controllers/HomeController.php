<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $notes = $user->notes()->latest()->limit(5)->get();
        
        return view('home', [
            'user' => $user,
            'notes' => $notes,
            'noteCount' => $user->notes()->count()
        ]);
    }
} 