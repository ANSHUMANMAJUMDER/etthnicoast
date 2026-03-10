<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function list()
    {
        return view('transfer.list');
    }

    public function add()
    {
        return view('transfer.add');
    }   

    public function import()
    {
        return view('transfer.import');
    }
}
