<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $menuItems = MenuItem::with('category')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->get();
            
        return view('admin.menu.index', compact('menuItems', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        MenuItem::create($request->all());

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        return view('admin.menu.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        $menuItem->update($request->all());

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->back()->with('success', 'Menu item deleted successfully!');
    }
}
