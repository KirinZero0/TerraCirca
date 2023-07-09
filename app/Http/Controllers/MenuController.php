<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->orderby('id', 'DESC')->paginate(10);
        return view('admin.pages.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.pages.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $menu = new Menu();
        $menu->fill($request->only(
            'custom_id',
            'name',
            'price',
            'description',
            'type',
            'photo')); 

        $menu->saveOrFail();

        return redirect()->route('admin.menu.index')->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('admin.pages.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $menu->fill($request->only(
            'custom_id',
            'name',
            'price',
            'description',
            'type' )); 

        if (!blank($request->photo)) {
            $menu->photo = $request->photo;
        }
    
        $menu->saveOrFail();
    
        return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully.');
    }
}
