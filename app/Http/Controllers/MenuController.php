<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::with(['menuItems' => function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }
        }])->get();

        if ($search) {
            $categories = $categories->filter(function ($category) {
                return $category->menuItems->count() > 0;
            });
        }

        return view('menu.index', compact('categories', 'search'));
    }
}
