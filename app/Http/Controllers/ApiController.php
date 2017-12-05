<?php

namespace App\Http\Controllers;

use App\City;
use App\Department;

class ApiController extends Controller
{
	public function count()
	{
		return count(City::all());
	}
	protected function getCities($name)
	{
		return City::with('department')
			->where('slug', 'like', str_slug($name))						// Check for accents
			->orWhere('slug', 'like', '%' . str_slug($name) . '%')			// Slug contains $name
			->orWhere('cp', 'like', $name . '%')							// Check for CP XX...
			->orWhere('cp', $name)											// Check for CP
			->get();
	}

	protected function getDepartments($department)
	{
		return Department::with('cities')
			->where('slug', str_slug($department))							// Get by slug
			->orWhere('slug', 'like', '%' . str_slug($department) . '%')	// or department code
			->orWhere('code', $department)									// or department code
			->get();
	}

	public function city($city)
	{
		$cities = $this->getCities($city);
		$departments = $this->getDepartments($city);

		/*
		 * If there are departments, prepend them to
		 * the returned list
		 */
		if (!$departments->isEmpty()) {
			$departments->each(function ($el) use ($cities) {
				$cities->prepend($el);
			});
		}

		/*
		 * Get only cities or departments
		 */
		if (request('type')) {
			$cities = $cities->filter(function ($el) {
				return $el->type === request('type');
			})->values();
		}

		if (request('department')) {
			$cities = $cities->filter(function ($el) {
				return $el->department->code === request('department');
			})->values();
		}

		/*
		 * Format output to fit jQuery UI Autocomplete
		 * and others
		 */
		if (request('formatted')) {
			return $cities->map(function ($cities) {
				return [
					'label'    => sprintf('%s (%s)', $cities->name, $cities->cp ?? $cities->code),
					'value'    => sprintf('%s (%s)', $cities->name, $cities->cp ?? $cities->code),
					'category' => ($cities->department) ? $cities->department->name . ' (' . $cities->department->code . ')' : 'Département',
					'data'     => $cities,
				];
			});
		}

		return $cities;
	}
}
