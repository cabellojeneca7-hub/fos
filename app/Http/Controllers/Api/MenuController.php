<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with('menuItems.reviews')->get();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
