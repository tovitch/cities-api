<?php

namespace App\Http\Controllers;

use App\City;

class CityController extends Controller
{
	public function index()
	{
		$cities = City::with(['department' => function ($query) {
			$query->orderBy('name', 'asc');
		}])->get();

		return view('cities.index', compact('cities'));
    }
}
