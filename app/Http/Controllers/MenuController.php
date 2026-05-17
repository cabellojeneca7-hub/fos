<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Cache::remember('menu_data', now()->addHours(1), function () {
            return Category::with('menuItems.reviews')->get();
        });

        return view('menu.index', compact('categories'));
    }
}
