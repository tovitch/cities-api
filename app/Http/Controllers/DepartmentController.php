<?php

namespace App\Http\Controllers;

use App\Department;

class DepartmentController extends Controller
{
	public function index()
	{
		$departments = Department::all();

		return view('departments.index', compact('departments'));
	}

	public function show(Department $department)
	{
		return view('departments.show', compact('department'));
	}
}
