<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('settings.general');
    }

    public function email()
    {
        return view('settings.email');
    }

    public function payment()
    {
        return view('settings.payment');
    }

    public function currency()
    {
        return view('settings.currency');
    }

    public function groupPermissions()
    {
        return view('settings.grouppermissions');
    }

    public function createpermission()
    {
        return view('settings.createpermission');
    }

    public function taxRates()
    {
        return view('settings.taxrates');
    }
}
