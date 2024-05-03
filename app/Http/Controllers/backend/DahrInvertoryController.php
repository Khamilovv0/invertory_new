<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

class DahrInvertoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateDahr()
    {
        return view('backend.invertory.create_invertory.dahr_create');
    }
}
