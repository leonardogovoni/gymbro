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

    public function progress()
    {
        return view('crud.progress');
    }

    public function progress_chart(Request $request)
    {
        if(is_null($request->input('user_id')) || is_null($request->input('exercise_id')))
            return redirect()->route('admin.progress'); 

        return view('crud.progress_chart', [
            'user_id' => $request->input('user_id'),
            'exercise_id' => $request->input('exercise_id')
        ]);
    }
}
