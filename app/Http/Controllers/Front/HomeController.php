<?php

namespace App\Http\Controllers\Front;

use App\Helpers\currency;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use NumberFormatter;

class HomeController extends Controller
{


    public function index()
    {
        $products = Product::with('category')->active()
            ->latest()
            ->limit(8)
            ->get();

        return view('front.home', compact('products'));

    }
}
