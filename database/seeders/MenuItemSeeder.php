<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Burgers (Category ID: 1)
        \App\Models\MenuItem::create([
            'name' => 'Yumburger', 
            'price' => 45.00, 
            'category_id' => 1, 
            'image' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=500&auto=format&fit=crop'
        ]);
        
        \App\Models\MenuItem::create([
            'name' => 'Cheeseburger', 
            'price' => 60.00, 
            'category_id' => 1, 
            'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Bacon Deluxe Burger', 
            'price' => 120.00, 
            'category_id' => 1, 
            'image' => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Double Quarter Pounder', 
            'price' => 180.00, 
            'category_id' => 1, 
            'image' => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Mushroom Swiss Burger', 
            'price' => 145.00, 
            'category_id' => 1, 
            'image' => 'https://images.unsplash.com/photo-1596662951482-0c4ba74a6df6?q=80&w=500&auto=format&fit=crop'
        ]);
        
        // Fries (Category ID: 2)
        \App\Models\MenuItem::create([
            'name' => 'Regular Fries', 
            'price' => 45.00, 
            'category_id' => 2, 
            'image' => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'French Fries (Large)', 
            'price' => 75.00, 
            'category_id' => 2, 
            'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Cheese Fries', 
            'price' => 95.00, 
            'category_id' => 2, 
            'image' => 'https://images.unsplash.com/photo-1585109649139-366815a0d713?q=80&w=500&auto=format&fit=crop'
        ]);
        
        // Drinks (Category ID: 3)
        \App\Models\MenuItem::create([
            'name' => 'Coke', 
            'price' => 35.00, 
            'category_id' => 3, 
            'image' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Iced Tea (Large)', 
            'price' => 50.00, 
            'category_id' => 3, 
            'image' => 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?q=80&w=500&auto=format&fit=crop'
        ]);

        \App\Models\MenuItem::create([
            'name' => 'Pineapple Juice', 
            'price' => 55.00, 
            'category_id' => 3, 
            'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?q=80&w=500&auto=format&fit=crop'
        ]);
    }
}