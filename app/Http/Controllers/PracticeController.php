<?php

namespace App\Http\Controllers;

use App\Practice;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function getPractice()
    {
        $practice = Practice::all();
        return response()->json($practice);
    }

    public function sample()
    {
        return view('practice');
    }

    public function sample2()
    {
        return view('practice2', ['testParam' => 'practice2']);
    }

    public function sample3()
    {
        return view('practice3', ['testParam' => 'test']);
    }
}
