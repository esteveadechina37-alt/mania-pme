<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        return view('manager.dashboard', compact('company'));
    }
}