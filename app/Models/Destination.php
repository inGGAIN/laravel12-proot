<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
	protected $fillable = [
		'name',
		'description',
		'location',
		'price',
		'image'
	];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
