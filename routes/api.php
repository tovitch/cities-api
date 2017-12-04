<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/city/{city}', function ($city) {
	$city = str_replace(' ', '-', $city);
	$c = \App\City::with('department')
		->where('name', $city)
		->orWhere('name', 'like', '%' . $city . '%')
		->orWhere('cp', 'like', $city . '%')
		->orWhere('cp', $city)
		->get();

	$d = \App\Department::where('name', $city)
		->orWhere('code', $city)
		->with('cities')->get();

	if (!$d->isEmpty()) {
		$d->each(function ($el) use ($c) {
			$c->prepend($el);
		});
	}

	if (request('type')) {
		$c = $c->filter(function ($el) {
			return $el->type === request('type');
		})->values();
	}

	if (request('formatted')) {
		return $c->map(function ($c) {
			return [
				'label' => sprintf('%s (%s)', $c->name, $c->cp ?? $c->code),
				'value' => sprintf('%s (%s)', $c->name, $c->cp ?? $c->code),
				'category' => ($c->department) ? $c->department->name . ' (' . $c->department->code . ')' : 'Département',
				'data'  => $c,
			];
		});
	}

	return $c;
});