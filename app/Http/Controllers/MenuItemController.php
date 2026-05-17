<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MenuItemController extends Controller
{
    private function clearMenuCache()
    {
        Cache::forget('menu_data');
    }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Image Processing with Intervention Image (v3)
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->cover(600, 600); // Resize and crop to 600x600
            
            $path = 'menu/' . $filename;
            Storage::disk('public')->put($path, (string) $img->encodeByExtension($image->getClientOriginalExtension()));
            $data['image'] = Storage::url($path);
        }

        MenuItem::create($data);
        $this->clearMenuCache();

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists and is a local file
            if ($menuItem->image && str_contains($menuItem->image, '/storage/menu/')) {
                $oldPath = str_replace('/storage/', '', $menuItem->image);
                Storage::disk('public')->delete($oldPath);
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->cover(600, 600);
            
            $path = 'menu/' . $filename;
            Storage::disk('public')->put($path, (string) $img->encodeByExtension($image->getClientOriginalExtension()));
            $data['image'] = Storage::url($path);
        }

        $menuItem->update($data);
        $this->clearMenuCache();

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Delete image file if exists
        if ($menuItem->image && str_contains($menuItem->image, '/storage/menu/')) {
            $oldPath = str_replace('/storage/', '', $menuItem->image);
            Storage::disk('public')->delete($oldPath);
        }

        $menuItem->delete();
        $this->clearMenuCache();
        return redirect()->back()->with('success', 'Menu item deleted successfully!');
    }
}
