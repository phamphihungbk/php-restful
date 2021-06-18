<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $data = [];
        return view('homepage', $data);
    }
}
