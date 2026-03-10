<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function chat()
    {
        return view('application.chat');
    }

    public function calendar()
    {
        return view('application.calendar');
    }

    public function email()
    {
        return view('application.email');
    }
}
