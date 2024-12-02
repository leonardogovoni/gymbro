<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function search(Request $request) {
        $search = $request->input('search');
        $results = Exercise::where('name', 'like', "%$search%")->get();
    
        return $results;
    }
}
