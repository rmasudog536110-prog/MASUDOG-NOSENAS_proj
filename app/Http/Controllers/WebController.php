<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function programs() {
    return view('index.programs'); 
}

public function exercises() {
    return view('index.exercises'); 
}


}
