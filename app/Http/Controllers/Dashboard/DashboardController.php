<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
     public function __construct()
    {
     //   $this->middleware(['auth', 'verified'])->except('index');   $this->middleware(['auth', 'verified'])->only('index');
    }
    public function index()
    {
        $title = 'Store';

        return view('dashboard.index');
    }
}
