@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Return a car</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rental.return') }}" method="POST" style="display:inline;">
                        @csrf
                        <div class="col-md-6 mb-3">
                            <label for="license_plate" class="form-label">License plate :</label>
                            <input type="text" name="license_plate" id="license_plate" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-danger btn-block">Return</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <h1>My Rentals</h1>
    @error('license_plate')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Return a car
    </button>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach ($rentals as $rental)
            <!-- Card start -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $rental->car->image }}" class="card-img-top"
                        alt="{{ $rental->car->brand }} - {{ $rental->car->model }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $rental->car->brand }} - {{ $rental->car->model }}</h5>
                        <p class="card-text">{{ $rental->car->license_plate }}</p>
                        <p class="card-text">From: {{ Carbon::parse($rental->start_date)->translatedFormat('j F Y') }}</p>
                        <p class="card-text">To: {{ Carbon::parse($rental->end_date)->translatedFormat('j F Y') }}</p>
                        <p class="card-text text-primary font-weight-bold">Rp. {{ number_format($rental->total_price, 2) }}
                        </p>
                    </div>
                    @if (!$rental->returned)
                        @if ($rental->onBook)
                            <div class="card-footer bg-success border-top-0">
                                <p class="text-white">Upcoming rental</p>
                            </div>
                        @else
                            <div class="card-footer bg-primary border-top-0">
                                <p class="text-white">On progress</p>
                            </div>
                        @endif
                    @else
                        <div class="card-footer bg-danger border-top-0">
                            <p class="text-white">Returned</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Card end -->
        @endforeach
    </div>
@endsection
