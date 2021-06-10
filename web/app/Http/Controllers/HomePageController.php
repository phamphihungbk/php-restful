<?php

namespace App\Http\Controllers;

class HomePageController extends Controller
{
    public function index()
    {
        $data = [];
        return view('homepage', $data);
    }
}
