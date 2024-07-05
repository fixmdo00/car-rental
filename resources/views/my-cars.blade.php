@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="addNewCarModal" tabindex="-1" aria-labelledby="addNewCarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewCarModalLabel">Add new car</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/my-cars">
                            @csrf

                            <div class="row mb-3">
                                <label for="brand" class="col-md-4 col-form-label text-md-end">Brand</label>

                                <div class="col-md-6">
                                    <input id="brand" type="text"
                                        class="form-control @error('brand') is-invalid @enderror" name="brand"
                                        value="{{ old('brand') }}" required autocomplete="brand" autofocus>

                                    @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="model" class="col-md-4 col-form-label text-md-end">Model</label>

                                <div class="col-md-6">
                                    <input id="model" type="text"
                                        class="form-control @error('model') is-invalid @enderror" name="model"
                                        value="{{ old('model') }}" required autocomplete="model">

                                    @error('model')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="license_plate" class="col-md-4 col-form-label text-md-end">License plate</label>

                                <div class="col-md-6">
                                    <input id="license_plate" type="text" class="form-control" name="license_plate"
                                        value="{{ old('license_plate') }}" required>

                                    @error('license_plate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="rental_rate_per_day" class="col-md-4 col-form-label text-md-end">Daily
                                    rate</label>

                                <div class="col-md-6">
                                    <input id="rental_rate_per_day" type="number"
                                        class="form-control @error('rental_rate_per_day') is-invalid @enderror"
                                        name="rental_rate_per_day" required autocomplete="new-rental_rate_per_day">

                                    @error('rental_rate_per_day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add car
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <h1>My cars</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewCarModal">
            Add new car
        </button>

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            @foreach ($cars as $car)
                <!-- Card start -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $car->image }}" class="card-img-top"
                            alt="{{ $car->brand }} - {{ $car->model }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                            <p class="card-text">{{ $car->license_plate }}</p>
                            <p class="card-text text-primary font-weight-bold">Rp
                                {{ number_format($car->rental_rate_per_day, 2) }} per day</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-left">
                                {{-- <a href="#" class="btn btn-success btn-block me-2">Edit</a> --}}
                                <form action="{{ route('my-cars.destroy', $car->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this car?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card end -->
            @endforeach
        </div>
    </div>
@endsection
