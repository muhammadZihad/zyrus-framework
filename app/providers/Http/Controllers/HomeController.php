<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        echo "Hi from index method";
    }

    public function home()
    {
        echo "Hi from home method";
    }
}