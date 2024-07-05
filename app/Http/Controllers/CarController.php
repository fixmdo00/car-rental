<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
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
    // public function allCars()
    // {
    //     $cars = Car::where('available', true)->get();
    //     return view('cars', ['cars' => $cars]);
    // }

    public function allCars(Request $request)
    {
        // $request->validate([
        //     'start_date' => 'required|date|after_or_equal:today',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        // ]);

        $query = Car::query();

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
    
        // Filter by model
        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        // Filter by availability within date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDoesntHave('rentals', function($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function($q) use ($request) {
                      $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                  });
            });
        } else {
            $startDate = Carbon::now()->startOfDay()->format('Y-m-d');
            $endDate = Carbon::now()->endOfDay()->format('Y-m-d');
            $query->whereDoesntHave('rentals', function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });
        }

        // Get the filtered list of cars
        // $cars = $query->where('available', true)->get();
        $cars = $query->get();


        return view('cars', ['cars' => $cars]);
    }

    public function myCars()
    {
        $cars = Car::where('user_id', Auth::id())->get();
        return view('my-cars', ['cars' => $cars]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20|unique:cars',
            'rental_rate_per_day' => 'required|numeric|min:0',
        ]);

        Car::create([
            'user_id' => Auth::id(),
            'brand' => $request->brand,
            'model' => $request->model,
            'image' => 'https://static.carmudi.co.id/W5iGZ-GD5f8U4_nHz8w--0VT_zU=/900x405/https://trenotomotif.com/ncs/images/daihatsu/All-new-Xenia/all-new-xenia.jpg',
            'license_plate' => $request->license_plate,
            'rental_rate_per_day' => $request->rental_rate_per_day,
            'available' => true
        ]);

        return redirect()->route('my-cars');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('my-cars');
    }
}
