<?php

use App\City;
use App\Department;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class CitiesTableSeeder extends Seeder
{
	protected $depts = [
	  '02', '27', '60', '77', '78', '91', '92', '93', '94', '95',
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$client = new Client();

		foreach ($this->depts as $dept) {
			$res = $client->request('GET', 'https://geo.api.gouv.fr/communes?fields=nom,centre,departement,codesPostaux&codeDepartement=' . $dept);
			$this->fetchCities($res);
		}

		$this->addForgotten('Amfreville-la-Campagne', '27370', '49.22032701931775', '0.924655463611235', '27');
	}

	protected function addForgotten($name, $cp, $lat, $lng, $codeDepartment)
	{
		$n_dept = Department::where('code', $codeDepartment)->first();

		City::create([
			'type'          => 'city',
			'name'          => $name,
			'slug'          => str_slug($name),
			'cp'            => $cp,
			'lat'           => $lat,
			'lng'           => $lng,
			'department_id' => $n_dept->id,
		]);
	}

	protected function fetchCities($cities)
	{
		foreach (json_decode($cities->getBody()) as $city) {
			$n_dept = Department::firstOrCreate([
				'type' => 'department',
				'name' => str_replace('-', ' ', $city->departement->nom),
				'slug' => str_slug($city->departement->nom),
				'code' => $city->departement->code,
			]);

			$this->createCity(
				$city->nom,
				$city->codesPostaux,
				$city->centre->coordinates[1],
				$city->centre->coordinates[0],
				$n_dept->code);

			if (strpos($city->nom, 'Saint') !== false) {
				$this->createCity(
					str_replace('Saint', 'St', $city->nom),
					$city->codesPostaux,
					$city->centre->coordinates[1],
					$city->centre->coordinates[0],
					$n_dept->code);
			}
		}
	}

	protected function createCity($name, $cp, $lat, $lng, $codeDepartment)
	{
		$dept = Department::where('code', $codeDepartment)->first();

		City::create([
			'type'          => 'city',
			'name'          => $name,
			'slug'          => str_slug($name),
			'cp'            => implode(':', $cp),
			'lat'           => $lat,
			'lng'           => $lng,
			'department_id' => $dept->id,
		]);
	}
}
