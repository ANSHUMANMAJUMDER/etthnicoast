<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function list()
    {
        return view('sales.list');
    }

    public function returnList()
    {
        return view('sales.returnlist');
    }

    public function return()
    {
        return view('sales.returns');
    }   

    public function edit()
    {
        return view('sales.edit');
    }

    public function details()
    {
        return view('sales.details');
    }
}
