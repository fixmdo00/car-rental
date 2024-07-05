<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
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
    
    public function allRentals()
    {
        $rentals = Rental::where('user_id', Auth::id())->get();

         $rentals->each(function ($rental) {
        $rental->onBook = Carbon::parse($rental->start_date)->isFuture();
    });

    return view('active-rentals', ['rentals' => $rentals]);
    }

    public function create()
    {
        // $cars = Car::where('available', true)->get();
        // return view('rentals.create', compact('cars'));
    }

    public function showConfirmationPage(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car = Car::find($request->car_id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $total_price = $this->calculateTotalPrice($car, $start_date, $end_date);

        // dd(number_format($total_price));

        return view('rental-confirmation', compact('car', 'start_date', 'end_date', 'total_price'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        $total_price = $request->total_price;

        // dd($request->start_date);

        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $total_price,
            'returned' => false,
        ]);

        $car->update(['available' => false]);

        return redirect()->route('active-rentals');
    }

    public function return(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string',
        ]);

        $user = auth()->user();
        $car = Car::where('license_plate', $request->license_plate)->first();

        if (!$car) {
            return redirect()->back()->withErrors(['license_plate' => 'Car not found.']);
        }

        $rental = Rental::where('user_id', $user->id)
            ->where('car_id', $car->id)
            ->where('returned', false)
            ->first();

        if (!$rental) {
            return redirect()->back()->withErrors(['license_plate' => 'This car is not rented by you or it has already been returned.']);
        }

        $startDate = Carbon::parse($rental->start_date)->startOfDay();
        if (Carbon::now()->startOfDay()->lessThan($startDate)) {
            return redirect()->back()->withErrors(['license_plate' => 'Cannot return this car, rental has not been started yet']);
        }

        $returnDate = Carbon::now()->startOfDay();
        $startDate = Carbon::parse($rental->start_date)->startOfDay(); // Ensure start_date is a Carbon instance and set to start of day
        $totalDays = $startDate->diffInDays($returnDate) + 1; // Include start day
        $totalCost = $totalDays * $car->rental_rate_per_day;

        $rental->update([
            'return_date' => $returnDate,
            'total_days' => $totalDays,
            'total_cost' => $totalCost,
            'returned' => true,
        ]);

        return redirect()->route('active-rentals')->with('success', 'Car returned successfully.');
    }

    public function calculateTotalPrice(Car $car, String $start_date, String $end_date) {
        $days = (new \DateTime($start_date))->diff(new \DateTime($end_date))->days + 1;
        $total_price = $car->rental_rate_per_day * $days;
        return $total_price;
    }

    


}
