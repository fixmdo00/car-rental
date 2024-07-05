<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

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
        $cars = Car::where('available', true)->get();
        return view('cars', ['cars' => $cars]);
    }
}
