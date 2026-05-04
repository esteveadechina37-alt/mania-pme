<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        return view('employee.dashboard', compact('company'));
    }
}