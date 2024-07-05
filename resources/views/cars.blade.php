@extends('layouts.app')

@section('content')
    <!-- Your Cars content goes here -->
    <div class="container">
        <h1>Cars</h1>

        <form action="{{ route('cars') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="brand" class="form-label">Brand:</label>
                    <input type="text" name="brand" id="brand" class="form-control" value="{{ request('brand') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label">Model:</label>
                    <input type="text" name="model" id="model" class="form-control" value="{{ request('model') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ request('start_date', now()->toDateString()) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ request('end_date', now()->toDateString()) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        {{-- {{ var_dump($cars) }} --}}
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            @foreach ($cars as $car)
                <!-- Card start -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $car->image }}" class="card-img-top" alt="{{ $car->brand }} - {{ $car->model }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                            <p class="card-text">{{ $car->license_plate }}</p>
                            <p class="card-text text-primary font-weight-bold">Rp
                                {{ number_format($car->rental_rate_per_day, 2) }} per day</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('rental.confirmation', ['car_id' => $car->id, 'start_date' => request('start_date', now()->toDateString()), 'end_date' => request('end_date', now()->toDateString())]) }}"
                                class="btn btn-warning btn-block">Rent this car</a>
                        </div>
                    </div>
                </div>
                <!-- Card end -->
            @endforeach
        </div>
    </div>
@endsection
