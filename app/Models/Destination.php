<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
	protected $fillable = ['name', 'destination', 'location', 'price', 'image'];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}
}
