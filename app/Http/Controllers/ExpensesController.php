<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function list()
    {
        return view('expenses.list');
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function category()
    {
        return view('expenses.category');
    }
}
