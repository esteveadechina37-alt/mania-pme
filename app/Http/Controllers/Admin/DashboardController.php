<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $totalUsers = $company->users()->count();

        return view('admin.dashboard', compact('company', 'totalUsers'));
    }
}