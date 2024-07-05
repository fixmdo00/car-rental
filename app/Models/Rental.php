<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'car_id', 
        'start_date', 
        'end_date', 
        'total_price', 
        'returned',
        'return_date',
        'total_days',
        'total_cost'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function return()
    {
        return $this->hasOne(ReturnModel::class);
    }
}
