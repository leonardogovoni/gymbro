<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index()
    {
        return view('crud.dashboard');
    }

    public function users()
    {
        return view('crud.users');
    }

    public function workout_plans()
    {
        return view('crud.workout_plans');
    }
}
