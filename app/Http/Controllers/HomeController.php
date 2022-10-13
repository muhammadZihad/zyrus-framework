<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return "Hi from index method";
    }

    public function home()
    {
        echo "Hi from home method";
    }
}