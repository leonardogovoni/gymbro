<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExercisesListController extends Controller
{
    public function index()
    {
        return view('statistics.exercises_list');
    }
}
