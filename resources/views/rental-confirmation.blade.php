@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Konfirmasi Sewa Mobil</h1>
        <div class="card">
            <div class="card-body">
                <h3>Detail Sewa</h3>
                <p><strong>Mobil:</strong> {{ $car->brand }} {{ $car->model }}</p>
                <p><strong>Tanggal Mulai:</strong> {{ Carbon::parse($start_date)->translatedFormat('j F Y') }}
                </p>
                <p><strong>Tanggal Selesai:</strong> {{ Carbon::parse($start_date)->translatedFormat('j F Y') }}
                </p>
                <p><strong>Total Harga:</strong> Rp. {{ number_format($total_price, 0, ',', '.') }}</p>
                <form action="{{ route('rental.confirm') }}" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="total_price" value="{{ $total_price }}">
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
